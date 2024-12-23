// Form validation utilities
const FormValidator = {
  validateName: (nama) => {
    return nama.length >= 3;
  },
  validateAge: (umur) => {
    return umur >= 5 && umur <= 60;
  },
  validatePhone: (phone) => {
    return /^[0-9]{10,13}$/.test(phone);
  },
  validateTeam: (team) => {
    return team.trim() !== "";
  },
};

// State management utilities
const StateManager = {
  // Local Storage functions
  saveToStorage: (key, value) => {
    localStorage.setItem(key, JSON.stringify(value));
  },
  getFromStorage: (key) => {
    const item = localStorage.getItem(key);
    return item ? JSON.parse(item) : null;
  },

  // Cookie functions
  setCookie: (name, value, days) => {
    const d = new Date();
    d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/`;
  },
  getCookie: (name) => {
    const cookies = document.cookie.split(";");
    for (let cookie of cookies) {
      const [cookieName, cookieValue] = cookie.split("=");
      if (cookieName.trim() === name) {
        return cookieValue;
      }
    }
    return "";
  },
  deleteCookie: (name) => {
    document.cookie = `${name}=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;`;
  },
};

// Form validation
function validateForm() {
  const nama = document.getElementById("nama").value;
  const umur = document.getElementById("umur").value;
  const nomorTelepon = document.getElementById("nomor_telepon").value;
  const timFavorit = document.getElementById("tim_favorit").value;

  // Validate each field
  if (!FormValidator.validateName(nama)) {
    showAlert("Nama harus minimal 3 karakter!", "error");
    return false;
  }

  if (!FormValidator.validateAge(umur)) {
    showAlert("Umur harus antara 5-60 tahun!", "error");
    return false;
  }

  if (!FormValidator.validatePhone(nomorTelepon)) {
    showAlert("Nomor telepon harus 10-13 digit angka!", "error");
    return false;
  }

  if (!FormValidator.validateTeam(timFavorit)) {
    showAlert("Silakan masukkan tim favorit Anda!", "error");
    return false;
  }

  // Save to localStorage
  StateManager.saveToStorage("lastRegistration", {
    nama,
    umur,
    tim: timFavorit,
    timestamp: new Date().toISOString(),
  });

  return true;
}

// Show alert function with animation
function showAlert(message, type = "success") {
  const alertDiv = document.createElement("div");
  alertDiv.className = `alert ${type} fade-in`;
  alertDiv.textContent = message;

  const main = document.querySelector("main");
  main.insertBefore(alertDiv, main.firstChild);

  setTimeout(() => {
    alertDiv.classList.add("fade-out");
    setTimeout(() => alertDiv.remove(), 300);
  }, 3000);
}

// Event Listeners
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registrationForm");

  if (form) {
    // Restore form data
    const savedData = StateManager.getFromStorage("lastRegistration");
    if (savedData) {
      document.getElementById("nama").value = savedData.nama || "";
      document.getElementById("umur").value = savedData.umur || "";
      document.getElementById("tim_favorit").value = savedData.tim || "";
    }

    // Add input event listeners
    const inputs = form.getElementsByTagName("input");
    for (let input of inputs) {
      input.addEventListener("input", function () {
        StateManager.saveToStorage(input.id, input.value);
      });
    }

    // Form submission
    form.addEventListener("submit", function (e) {
      if (!validateForm()) {
        e.preventDefault();
      }
    });
  }

  // Add card animations
  const cards = document.querySelectorAll(".team-card");
  cards.forEach((card) => {
    card.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-10px)";
    });
    card.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0)";
    });
  });
});
