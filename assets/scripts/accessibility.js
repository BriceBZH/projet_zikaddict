document.addEventListener('DOMContentLoaded', () => {
    const showTools = document.getElementById('tools');
    const tools = document.getElementById('accessibility-tools');

    showTools.addEventListener('click', () => {
        if (tools.style.display === 'none' || tools.style.display === '') {
            tools.style.display = 'flex';
        } else {
            tools.style.display = 'none';
        }
    });

    const increaseText = document.getElementById('increase_text_size');
    const decreaseText = document.getElementById('decrease_text_size');
    const darkMode = document.getElementById('dark_mode');
    const body = document.body;
    let currentFontSize = parseFloat(window.getComputedStyle(body, null).getPropertyValue('font-size'));

    increaseText.addEventListener('click', () => {
        currentFontSize += 1;
        body.style.fontSize = currentFontSize + 'px';
    });

    decreaseText.addEventListener('click', () => {
        currentFontSize -= 1;
        body.style.fontSize = currentFontSize + 'px';
    });

    darkMode.addEventListener('click', () => {
        body.classList.toggle('dark_mode');
    });
});
