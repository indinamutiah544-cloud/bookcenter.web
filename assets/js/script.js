function initDarkMode() {
    const toggleBtns = document.querySelectorAll('.dark-mode-toggle');
    
    function setTheme(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('theme', theme);
        
        toggleBtns.forEach(btn => {
            if(theme === 'dark') {
                btn.innerHTML = '<i class="bi bi-sun-fill"></i>';
                btn.classList.remove('btn-outline-dark');
                btn.classList.add('btn-outline-light');
            } else {
                btn.innerHTML = '<i class="bi bi-moon-fill"></i>';
                btn.classList.remove('btn-outline-light');
                btn.classList.add('btn-outline-dark');
            }
        });
    }

    const currentTheme = localStorage.getItem('theme') || 'light';
    
    // We already set the theme in header <script> to prevent FOUC, 
    // but we need to update the button icons here
    setTheme(currentTheme);

    toggleBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const theme = document.documentElement.getAttribute('data-bs-theme');
            setTheme(theme === 'dark' ? 'light' : 'dark');
        });
    });
}

document.addEventListener('DOMContentLoaded', initDarkMode);