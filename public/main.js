
function load() {    
    fetch("../php/adatok.php")
    .then((response) => {
        try {
            const json = response.json();
            return json;
        } catch (e) {
            window.alert(e);
        }
        return response;
    })
    .then((data) => {
        initialLoad(data);
    });
}

var vanBevetel, vanKiadas = false;
var kiadasok = 0;

function initialLoad(data) {
    let keret = data.keret;

    $("#egyenleg-p").text(`${data.egyenleg} Ft`);

    const transactions = data.transactions;
    if (transactions.length === 0) return;
    for (const transaction of transactions) {
        const idopont = transaction.idopont;
        const kategoria = transaction.kategoria;
        const note = transaction.note;
        const osszeg = parseInt(transaction.osszeg);
        if ( new Date(idopont).getMonth() === new Date().getMonth() ) {
            addMonthTransaction(osszeg, kategoria, idopont, note)
        }
        addTransaction(osszeg, kategoria, idopont, note);
    }

    if (!vanBevetel) {
        const p = $("<p>").addClass("placeholder")
                .text("Még nincs bevétel.")
        $("#bevetelek").append(p);
    }
    if (!vanKiadas) {
        const p = $("<p>").addClass("placeholder")
                .text("Még nincs kiadás.")
        $("#kiadasok").append(p);
    }

    if (kiadasok > keret) {
        window.alert("A kiadásaid túllépték a keretet!");
    }
}

function addMonthTransaction(osszeg, kategoria, date, note) {
    const t_div = $("<div>").addClass("transaction-card");
    const t_osszeg = $("<p>").addClass("t-osszeg");
    t_osszeg.text(`${osszeg} Ft`);
    const t_cat = $("<span>").addClass("t-cat");
    t_cat.text(kategoria);
    const t_date = $("<p>").addClass("t-date");
    t_date.text(date);
    const t_note = $("<p>").addClass("t-note");
    t_note.text(note);
    t_div.append(t_osszeg, t_cat, t_date, t_note);
    
    var cont;
    if (!vanKiadas) {
        cont = $("<div>").addClass("transactions");
        $("#havi").append(cont);
    }
    else {
        cont = $("#kiadasok>.transactions")
    }
    cont.append(t_div);
}

function addTransaction(osszeg, kategoria, date, note) {
    const t_div = $("<div>").addClass("transaction-card");
    const t_osszeg = $("<p>").addClass("t-osszeg");
    t_osszeg.text(`${Math.abs(osszeg)} Ft`);
    const t_cat = $("<span>").addClass("t-cat");
    t_cat.text(kategoria);
    const t_date = $("<p>").addClass("t-date");
    t_date.text(date);
    const t_note = $("<p>").addClass("t-note");
    t_note.text(note);
    t_div.append(t_osszeg, t_cat, t_date, t_note);
    if (osszeg < 0) {
        kiadasok += Math.abs(osszeg);
        var cont;
        if (!vanKiadas) {
            cont = $("#kiadasok .placeholder").remove();
            cont = $("<div>").addClass("transactions");
            $("#kiadasok").append(cont);
        }
        else {
            cont = $("#kiadasok>.transactions")
        }
        cont.append(t_div);
        vanKiadas = true;
    }
    else {
        var cont;
        if (!vanBevetel) {
            cont = $("#bevetelek .placeholder").remove();
            cont = $("<div>").addClass("transactions");
            $("#bevetelek").append(cont);
        }
        else {
            cont = $("#bevetelek>.transactions");
        }
        cont.append(t_div);
        vanBevetel = true;
    }
}

$(document).ready(function () {    
    load();

    $("#idopont").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        firstDay: 1,
    });

    $("#keretmentes").on("click", async function() {
        const res = await fetch("../php/keret.php", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
                keret: $("#keret").val(),
            })
        });
        if (!res.ok) {
            window.alert("error");
            throw new Error("problem");
        }
        const resText = await res.text();
        if (resText !== "ok") {
            window.alert("error");
            throw new Error(resText);
        }
        window.alert("Sikeresen rögzítve!");
    })

    // Köszönjük a Gemininek
    $("#osszeg").on("input", function () {
        // 1. Save the current cursor position so it doesn't jump to the end
        let cursorPosition = osszeg.selectionStart;
        const originalLength = osszeg.value.length;

        // 2. Remove anything that is NOT a digit
        let rawValue = osszeg.value.replace(/\D/g, "");
        // 3. Add a space every 3 digits from the right ("1234567" -> "1 234 567")
        let formattedValue = rawValue.replace(/\B(?=(\d{3})+(?!\d))/g, " ");

        osszeg.value = formattedValue;
        // 5. Adjust and restore the cursor position so typing feels natural
        const newLength = formattedValue.length;
        cursorPosition = cursorPosition + (newLength - originalLength);
        osszeg.setSelectionRange(cursorPosition, cursorPosition);
    });

    $("#bev-add").on("click", function () {
        const radioValues = ["Fizetés", "Nyugdíj", "Bevétel", "GYES / GYED", "Számla", "Befektetés", "Kripto", "Egyéb"];
        setUpEditor("Bevétel hozzáadása", "bevetel", radioValues, "Hozzáadás");
    });

    $("#kiad-add").on("click", function () {
        const radioValues = ["Egészség", "Élelmiszer", "Ruházat", "Játék", "Hobbi", "Közlekedés", "Nyaralás", "Megtakarítás", "Egyéb"];
        setUpEditor("Kiadás hozzáadása", "kiadas", radioValues, "Hozzáadás");
    });

    function setUpEditor(title, etype, radioValues, btnText) {
        $("#editor > h3").text(title);
        $("#editor > #submit").text(btnText);
        $("#categories").append(
            $("<p>").text("Kategória")
        );
        for (val of radioValues) {
            const label = $("<label></label>").text(val).attr("for", val);
            const newRadio = $(`<input type="radio" name="cat" id="${val}" value="${val}" ${val=="Egyéb"?"checked":""}>`);
            $("#categories").append(newRadio, label);
        }

        $("#editor-cont").css("display", "flex");

        $("#submit").on("click.submit", async function() {
            var osszeg = parseInt($("#osszeg").val().replace(/\s/g, ""));
            if (etype==="kiadas") { osszeg *= -1 };
            const idopont = $("#idopont").val();
            const category = $("input[name='cat']:checked").val();
            const note = $("#note").val();

            if (!osszeg || !idopont || !category || !note) {
                window.alert("Nem adtad meg az összes adatot!");
                return;
            }

            const res = await fetch("../php/add.php", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({
                    osszeg: osszeg,
                    idopont: idopont,
                    category: category,
                    note: note
                })
            });
            if (!res.ok) {
                window.alert("error");
                throw new Error("problem");
            }
            const resText = await res.text();
            if (resText !== "ok") {
                window.alert("error");
                throw new Error(resText);
            }

            closeEditor();
            window.alert("Sikeresen rögzítve!");
            addTransaction(osszeg, category, idopont, note);
            const e = $("#egyenleg-p");
            e.text(`${parseInt(e.text().replace(/\D/g, "")) + osszeg} Ft`);

        });
        
    }

    function closeEditor() {
        $("#submit").off(".submit");
        $("#editor-cont").css("display", "none");
        $("#osszeg").val("");
        $("#idopont").val("");
        $("#note").val("");
        $("#categories").empty();
        $("#note-cont>span").text("0 / 100 karakter");
    };

    $("#close-editor").on("click", closeEditor);

    $("#close-editor").on("click", function () {
        $("#submit").off(".submit");
        $("#editor-cont").css("display", "none");
        $("#categories").empty();
    });

    $("#note").on("input", function () {
        const text = $("#note").val();
        if (text.length >= 100) {
        $("#note").val(text.substring(0, 100));
        }
        $("#note-cont>span").text($("#note").val().length + " / 100 karakter");
    });
});
