document.addEventListener("alpine:init", () => {
  Alpine.data("formValidation", () => ({
    form: {
      name: "",
      username: "",
      email: "",
      password: "",
      confirmPassword: "",
      role: ""
    },
    errors: {},
    isFormSubmitted: false,

    validateName() {
      return this.form.name.length > 3;
    },

    validateUserName() {
      return this.form.username.length > 3;
    },

    validateEmail() {
      return this.form.email.length > 10;
    },

    validatePassword() {
      return this.form.password.length > 6;
    },

    validateConfirmPassword() {
      return this.form.password === this.form.confirmPassword;
    },

    validateRole() {
      return this.form.role.length > 3;
    },

    validateForm() {
      const isValid =
        this.validateName() &&
        this.validateUserName() &&
        this.validateEmail() &&
        this.validatePassword() &&
        this.validateConfirmPassword() &&
        this.validateRole();

      this.isFormSubmitted = true;
      return isValid;
    },

    async handleSubmit(event) {
      event.preventDefault();
      const { name, username,email, password, role } = this.form;
      if (this.validateForm()) {
        // Form submission logic here
        try {
          const response = await fetch("/api/admin/create", {
            method: "POST",
            credentials: "include",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ name, username,email, password, role }),
          });

          if (response.ok) {
            // this.showMessage("User created successfully.", "success");
            // this.resetForm();
            window.location.href = "/users";
          } else {
            window.location.href = "/users";
            // this.showMessage("Failed to create user.", "error");
          }
        } catch (error) {
          window.location.href = "/users";
          //   this.showMessage("An error occurred.", "error");
        }
      }
    },

    resetForm() {
      this.form = {
        name: "",
        email:"",
        username: "",
        password: "",
        confirmPassword: "",
        role: ""
      };
      this.errors = {};
      this.isFormSubmitted = false;
    },

    showMessage(msg, type) {
      alert(`${type.toUpperCase()}: ${msg}`); // Replace with a custom toast or modal if needed
    }
  }));
});
