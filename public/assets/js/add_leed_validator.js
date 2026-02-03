document.addEventListener("alpine:init", () => {
  Alpine.data("formValidation", () => ({
    form: {
      name: "",
      phoneNumber: "",
      projectId: "",
      statusId: "",
      assignedToId: "",
      createdById: ""
    },
    errors: {},
    isFormSubmitted: false,

    validateName() {
      return this.form.name.length > 3;
    },

    validatePhoneNumber() {
      return this.form.phoneNumber.length > 10;
    },

    validateProjectId() {
      return this.form.projectId.length > 23;
    },

    validateStatusId() {
      return this.form.statusId.length > 23;
    },

    validateAssignedToId() {
      return this.form.assignedToId.length > 23;
    },

    validateCreatedById() {
      return this.form.createdById.length > 23;
    },

    validateForm() {
      const isValid =
        this.validateName() &&
        this.validatePhoneNumber() &&
        this.validateProjectId() &&
        this.validateStatusId() &&
        this.validateAssignedToId();

      this.isFormSubmitted = true;
      return isValid;
    },

    async handleSubmit(event) {
      event.preventDefault();
      const { name, username, phoneNumber, projectId, assignedToId, statusId } =
        this.form;
      if (this.validateForm()) {
        // Form submission logic here
        try {
          const response = await fetch("/api/leeds/create", {
            method: "POST",
            credentials: "include",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              name,
              username,
              phoneNumber,
              projectId,
              assignedToId,
              statusId
            })
          });

          if (response.ok) {
            // this.showMessage("User created successfully.", "success");
            // this.resetForm();
            window.location.href = "/leeds";
          } else {
            window.location.href = "/leeds";
            // this.showMessage("Failed to create user.", "error");
          }
        } catch (error) {
          window.location.href = "/leeds";
          //   this.showMessage("An error occurred.", "error");
        }
      }
    },

    resetForm() {
      this.form = {
        name: "",
        username: "",
        phoneNumber: "",
        projectId: "",
        assignedToId: "",
        createdById: "",
        statusId: ""
      };
      this.errors = {};
      this.isFormSubmitted = false;
    },

    showMessage(msg, type) {
      alert(`${type.toUpperCase()}: ${msg}`); // Replace with a custom toast or modal if needed
    }
  }));
});
