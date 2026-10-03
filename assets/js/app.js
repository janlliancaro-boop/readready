document.addEventListener('DOMContentLoaded', function () {
    const avatarButtons = document.querySelectorAll('.avatar-option');
    const avatarInput = document.getElementById('avatar');

    if (avatarButtons.length && avatarInput) {
        avatarButtons.forEach((button) => {
            button.addEventListener('click', function () {
                avatarButtons.forEach((item) => item.classList.remove('active'));
                this.classList.add('active');
                avatarInput.value = this.dataset.avatar;
            });
        });
    }

    const usernameField = document.getElementById('nickname');
    if (usernameField) {
        usernameField.addEventListener('input', function () {
            const value = this.value.trim();
            if (value) {
                localStorage.setItem('readready_nickname', value);
            }
        });
    }

    if (avatarInput && avatarInput.value) {
        localStorage.setItem('readready_avatar', avatarInput.value);
    }

    const popup = document.getElementById('achievementPopup');
    if (popup) {
        popup.style.display = 'block';
        setTimeout(() => {
            popup.style.display = 'none';
        }, 2500);
    }
});
