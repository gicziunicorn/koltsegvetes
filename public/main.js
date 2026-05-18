console.log("fut");

fetch("../php/adatok.php").then(response => response.json())
.then(data => {
    console.log(data);
});