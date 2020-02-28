const EmailRegex = /^\S+@\S+$/;

export const validateRegister = (data) => {
    const errors = {};

    if (!data.name) {
        errors.name = "Name is required"
    }
    if (!data.email) {
        errors.email = "Email is required"
    } else if (!EmailRegex.test(data.email)) {
        errors.email = "Email must be a valid email address"
    }
    if (!data.password) {
        errors.password = "Password is required"
    } else if (data.password < 4) {
        errors.password = "Password must be at least 4 characters"
    }
    if (!data.password_confirmation) {
        errors.password_confirmation = "Please confirm your password"
    } else if (data.password_confirmation !== data.password) {
        errors.password_confirmation = "Password must be matched"
    }

    return {
        errors,
        isValid: Object.keys(errors).length === 0
    }
}

export const validateLogin = (data) => {
    const errors = {};

    if (!data.email) {
        errors.email = "Email is required"
    } else if (!EmailRegex.test(data.email)) {
        errors.email = "Email must be a valid email address"
    }
    if (!data.password) {
        errors.password = "Password is required"
    }

    return {
        errors,
        isValid: Object.keys(errors).length === 0
    }
}

export const validateTransaction = (data) => {
    const errors = {};

    if (!data.on) {
        errors.on = "Expense/Income on? is required"
    }
    if (!data.type) {
        errors.type = "Type is required"
    }
    if (!data.amount) {
        errors.amount = "Amount is required"
    }
    if (!data.location) {
        errors.location = "Location is required"
    }

    return {
        errors,
        isValid: Object.keys(errors).length === 0
    }
}