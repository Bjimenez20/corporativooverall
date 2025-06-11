document.getElementById("btn_submit").addEventListener("click", function (e) {
    e.preventDefault();

    const btn = this;

    let validador = {
        full_name: document.getElementById("full_name").value,
        position: document.getElementById("position").value,
        company: document.getElementById("company").value,
        business_sector: document.getElementById("business_sector").value,
        email: document.getElementById("email").value,
        country: document.getElementById("country").value,
        unidad: document.getElementById("unidad").value,
        message: document.getElementById("message").value
    };

    let allFieldsFilled = true;
    let emptyFields = [];

    for (let key in validador) {
        if (validador.hasOwnProperty(key)) {
            let element = document.getElementById(key);
            if (!validador[key]) {
                allFieldsFilled = false;
                element.classList.add("is-invalid");
                emptyFields.push(element.getAttribute("data-title") || element.placeholder || key);
            } else {
                element.classList.remove("is-invalid");
                element.classList.add("is-valid");
            }
        }
    }

    if (allFieldsFilled) {
        btn.disabled = true;
        btn.innerHTML = 'Cargando...';
        $.ajax({
            type: "POST",
            url: '.././controllers/contact_me.php',
            data: $('#formContact').serialize(),
            success: function (response) {
                Swal.fire({
                    title: "Solicitud enviada",
                    text: "Tus datos han sido enviados exitosamente",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                }).then(() => {
                    location.reload();
                });
            },
            complete: function () {
                btn.disabled = false;
                btn.innerHTML = 'Enviar mensaje';
            }
        });
    } else {
        let errorMessage = "<ul style='list-style-type: none; margin: 0; padding: 0'>";
        errorMessage += "<li>Faltan campos por completar:</li><br>";
        emptyFields.forEach((title) => {
            errorMessage += `<li>${title}</li>`;
        });
        errorMessage += "</ul>";

        Swal.fire({
            title: "Datos inválidos",
            html: errorMessage,
            icon: "error",
            confirmButtonText: "Aceptar",
        });

        btn.disabled = false;
        btn.innerHTML = 'Enviar mensaje';
    }
});
