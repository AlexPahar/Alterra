document.addEventListener("DOMContentLoaded", function () {
    const phone = document.getElementById('phone');
    const form = document.querySelector('.top-wrapper');
    const deleteBtn = document.querySelectorAll('.close-btn');
    const phoneList = document.querySelector(".contact-wrap");

    Inputmask("+7(999) 999-9999").mask(phone);

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        let object = {};
        new FormData(form).forEach(function (value, key) {
            object[key] = value;
        })

        let response = await fetch('/alterra/api/phones/create.php', {
            method: "POST",
            body: JSON.stringify(object)
        });

        let result = await response.json();

        console.log(result)
        if (result.status === "success") {
            let newEl = document.createElement("div");
            newEl.classList.add("contact");
            newEl.innerHTML = `
                    <div class="name-contact">
                        <div class="name">${object.name}</div>
                    </div>
                    <div class="phone-contact">
                        ${object.phone}                
                    </div>`;
            phoneList.append(newEl);
        }
    })

    deleteBtn.forEach(function (element) {
        element.addEventListener('click', async function (e) {
            if (e.target?.dataset?.id) {
                let object = {'id': e.target.dataset.id};

                let response = await fetch('/alterra/api/phones/delete.php', {
                    method: "POST",
                    body: JSON.stringify(object)
                });

                let result = await response.json();

                if (result.status === "success") {
                    e.target.closest('.contact').remove();
                }
            }
        })
    })
})