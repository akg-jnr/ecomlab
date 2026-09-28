"use strict";

for (const formId of ["register-form", "login-form"]) {
    const form = document.getElementById(formId);
    if (!form) continue;
    form.addEventListener("submit", event => {
        const registration = formId === "register-form";
        const fields = registration
            ? ["name", "email", "password", "country", "city", "contact", "address"]
            : ["email", "password"];
        const names = {
            name: "customer_name", email: "customer_email", password: "customer_pass",
            country: "customer_country", city: "customer_city", contact: "customer_contact",
            address: "customer_address"
        };
        const values = {};
        for (const field of fields) {
            const input = form.elements.namedItem(names[field]);
            values[field] = field === "password" ? input.value : input.value.trim();
            document.getElementById(names[field] + "-error").textContent = "";
            input.removeAttribute("aria-invalid");
        }
        const errors = validationErrors(values, registration);
        const invalidFields = Object.keys(errors);
        if (invalidFields.length) {
            event.preventDefault();
            for (const field of invalidFields) {
                document.getElementById(names[field] + "-error").textContent = errors[field];
                form.elements.namedItem(names[field]).setAttribute("aria-invalid", "true");
            }
            form.elements.namedItem(names[invalidFields[0]]).focus();
        }
    });
}
