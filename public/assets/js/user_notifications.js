document.addEventListener("alpine:init", () => {
  Alpine.data("cardRenderer", () => ({
    cards: [],

    async init() {
      try {
        const response = await fetch("/api/users/notifications", {
          method: "GET",
          headers: {
            "Content-Type": "application/json"
          }
        });
        if (response.ok) {
          const data = await response.json();

          this.cards = data.map((item) => ({
            _id: item?._id,
            title: item?.title || "Notification",
            body: item?.message,
            time: new Date(item?.timeStamp).toLocaleString() // Format the date here
          }));
        } else {
          console.error("Failed to fetch notifications");
        }
      } catch (error) {
        console.error("Error fetching notifications:", error);
      }
    },

    async removeCard(id) {
      try {
        const response = await fetch(`/api/users/notification/${id}`, {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json"
          }
        });
        if (response.ok) {
          this.cards = this.cards.filter((card) => card._id !== id);
        } else {
          console.error("Failed to delete notification");
        }
      } catch (error) {
        console.error("Error deleting notification:", error);
      }
    },

    async removeAllCards() {
      try {
        const response = await fetch("/api/users/notifications", {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json"
          }
        });
        if (response.ok) {
          this.cards = [];
        } else {
          console.error("Failed to delete all notifications");
        }
      } catch (error) {
        console.error("Error deleting all notifications:", error);
      }
    }
  }));
});
