// =====================================
// AI LEARN DASHBOARD JAVASCRIPT
// =====================================

console.log("Dashboard JS Loaded");


// =====================================
// THREE DOT MENU
// =====================================

const menuButton = document.getElementById("menuButton");
const closeMenu = document.getElementById("closeMenu");
const sidebar = document.querySelector(".sidebar");
const menuOverlay = document.getElementById("menuOverlay");


// Open menu
if (menuButton) {

    menuButton.addEventListener("click", function () {

        sidebar.classList.add("open");
        menuOverlay.classList.add("show");

    });

}


// Close menu
if (closeMenu) {

    closeMenu.addEventListener("click", function () {

        sidebar.classList.remove("open");
        menuOverlay.classList.remove("show");

    });

}


// Close when clicking outside
if (menuOverlay) {

    menuOverlay.addEventListener("click", function () {

        sidebar.classList.remove("open");
        menuOverlay.classList.remove("show");

    });

}


// =====================================
// SIDEBAR MENU
// =====================================

const menuLinks = document.querySelectorAll(".sidebar-menu a");

menuLinks.forEach(link => {

    link.addEventListener("click", function () {

        menuLinks.forEach(item => {
            item.classList.remove("active");
        });

        this.classList.add("active");

        sidebar.classList.remove("open");
        menuOverlay.classList.remove("show");

    });

});


// =====================================
// CONTINUE LEARNING BUTTON
// =====================================

const continueBtn = document.querySelector(".dashboard-btn");

if (continueBtn) {

    continueBtn.addEventListener("click", function () {

        console.log("Learning path button clicked");

    });

}
// =====================================
// ROADMAP CONTINUE BUTTON
// =====================================

function startLearning(topic) {

    alert(
        "Great! 🚀\n\nYou are continuing: " + topic
    );

}
// =====================================
// PROFILE EDIT
// =====================================

const editProfileBtn = document.getElementById("editProfileBtn");
const editProfileForm = document.getElementById("editProfileForm");
const cancelProfileBtn = document.getElementById("cancelProfileBtn");
const saveProfileBtn = document.getElementById("saveProfileBtn");

if (editProfileBtn) {

    editProfileBtn.addEventListener("click", function () {

        editProfileForm.style.display = "block";
        editProfileBtn.style.display = "none";

    });

}

if (cancelProfileBtn) {

    cancelProfileBtn.addEventListener("click", function () {

        editProfileForm.style.display = "none";
        editProfileBtn.style.display = "inline-flex";

    });

}

if (saveProfileBtn) {

    saveProfileBtn.addEventListener("click", function () {

        alert("Profile changes saved successfully! ✅");

        editProfileForm.style.display = "none";
        editProfileBtn.style.display = "inline-flex";

    });

}
