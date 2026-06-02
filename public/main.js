console.log("fut");
const getElement = (e) => document.querySelector(e);

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
    console.log(data);
  });

$(document).ready(function () {
  $("#idopont").datepicker({
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    firstDay: 1,
  });

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
    const radioValues = [
      "Fizetés",
      "Nyugdíj",
      "Bevétel",
      "GYES / GYED",
      "Számla",
      "Befektetés",
      "Kripto",
      "Egyéb",
    ];
    setUpEditor("Bevétel hozzáadása", "bevetel", radioValues, "Hozzáadás");
  });

  $("#kiad-add").on("click", function () {
    const radioValues = [
      "Egészség",
      "Élelmiszer",
      "Ruházat",
      "Játék",
      "Hobbi",
      "Közlekedés",
      "Nyaralás",
      "Megtakarítás",
      "Egyéb",
    ];
    setUpEditor("Kiadás hozzáadása", "kiadas", radioValues, "Hozzáadás");
  });

  let submitListener = undefined;

    $("#bev-add").on("click", function() {
        const radioValues = ["Fizetés", "Nyugdíj", "Bevétel", "GYES / GYED", "Számla", "Befektetés", "Kripto", "Egyéb"];
        setUpEditor("Bevétel hozzáadása", "bevetel", radioValues, "Hozzáadás");
    });


    $("#kiad-add").on("click", function() {
        const radioValues = ["Egészség", "Élelmiszer", "Ruházat", "Játék", "Hobbi", "Közlekedés", "Nyaralás", "Megtakarítás", "Egyéb"];
        setUpEditor("Kiadás hozzáadása", "kiadas", radioValues, "Hozzáadás");
    });

    let submitListener = undefined;

    function setUpEditor(title, etype, radioValues, btnText) {
        $("#editor > h3").text(title);
        $("#editor > #submit").text(btnText);
        $("#categories").append(
            $("<p></p>").text("Kategória")
        );
        for (val of radioValues) {
            const label = $("<label></label>").text(val).attr("for", val);
            const newRadio = $(`<input type="radio" name="cat" id="${val}" value="${val}" ${val=="Egyéb"?"checked":""}>`);
            $("#categories").append(newRadio, label);
        }

        $("#editor-cont").css("display", "flex");

        $("#submit").on("click.submit", async function() {
            console.log("submit!");
            var osszeg = parseInt($("#osszeg").val().replace(/\s/g, ""));
            if (etype==="kiadas") { osszeg *= -1 };
            const idopont = $("#idopont").val();
            const category = $("input[name='cat']:checked").val();
            const note = $("#note").val();
            console.log(osszeg, idopont, category, note);
            //throw new Error("ok");
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
        });
        
    }

    function closeEditor() {
        $("#submit").off(".submit");
        $("#editor-cont").css("display", "none");
        $("#osszeg").val("");
        $("#idopont").val("");
        $("#note").val("");
        $("#categories").empty();
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
