document.addEventListener("alpine:init", () => {
  Alpine.data("realtimeNotify", () => ({
    notifications: [],
    async init() {
      const eventSource = new EventSource(`/api/sse/connect`);
      eventSource.addEventListener("notify", (event) => {
        const data = JSON.parse(event.data);
        this.addNotification(data);
        this.playNotificationSound();
      });

      this.notifications = await getUserNotifications();
    },

    playNotificationSound() {
      const iframe = document.createElement("iframe");
      iframe.src = "assets/sounds/notification.mp3"; // Path to your sound file
      iframe.allow = "autoplay";
      iframe.style.display = "none"; // Hide the iframe
      document.body.appendChild(iframe);

      // Clean up the iframe after the sound has played
      setTimeout(() => {
        document.body.removeChild(iframe);
      }, 6000); // Adjust timing to match the sound duration
    },

    addNotification(newNotification) {
      this.notifications.push(newNotification);
    },

    removeNotification(value) {
      this.notifications = this.notifications.filter((d) => d._id !== value);
      this.markAsRead(value);
    },

    clearNotifications() {
      this.notifications = [];
      this.MarkAllAsRead();
    },

    async markAsRead(value) {
      try {
        const response = await fetch(`/api/users/notifications/${value}`, {
          method: "PATCH",
          credentials: "include",
          headers: {
            "Content-Type": "application/json"
          }
        });

        if (!response.ok) {
          throw new Error("Failed to mark notification as read");
        }

        return true;
      } catch (error) {
        console.error(error);
      }
    },

    async MarkAllAsRead() {
      try {
        const response = await fetch(`/api/users/notifications`, {
          method: "PATCH",
          credentials: "include",
          headers: {
            "Content-Type": "application/json"
          }
        });

        if (!response.ok) {
          throw new Error("Failed to mark all notifications as read");
        }

        return true;
      } catch (error) {
        console.error(error);
      }
    }
  }));
});
