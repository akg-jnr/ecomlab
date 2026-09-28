"use strict";


function validationErrors(values, registration) {
    const errors = {};
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[0-9+\- ]{7,15}$/;
    const passRegex = /^(?=.*[0-9]).{8,}$/u;
    const length = value => Array.from(value).length;
    const passBytes = new TextEncoder().encode(values.password).length;

    if (!emailRegex.test(values.email) || length(values.email) > 50) {
        errors.email = "Enter a valid email of no more than 50 characters.";
    }
    if (!values.password || passBytes > 72 || values.password.includes("\0")) {
        errors.password = "Enter your password (maximum 72 UTF-8 bytes).";
    }
    if (!registration) return errors;

    if (length(values.name) < 2 || length(values.name) > 100) {
        errors.name = "Enter a name of 2 to 100 characters.";
    }
    if (!passRegex.test(values.password) || /[\r\n]/.test(values.password) || passBytes > 72 || values.password.includes("\0")) {
        errors.password = "Use at least 8 characters and one digit, with a maximum of 72 UTF-8 bytes.";
    }
    if (!values.country || length(values.country) > 30) {
        errors.country = "Choose your country.";
    }
    if (!values.city || length(values.city) > 30) {
        errors.city = "Enter a city of 1 to 30 characters.";
    }
    if (!phoneRegex.test(values.contact) || (values.contact.match(/[0-9]/g) || []).length < 7) {
        errors.contact = "Use at least 7 digits and at most 15 characters; +, - and spaces are allowed.";
    }
    if (!values.address || length(values.address) > 255) {
        errors.address = "Enter an address of 1 to 255 characters.";
    }
    return errors;
}

