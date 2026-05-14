// Hero AI suggestion chips: clicking pre-fills the prompt textarea.
document.addEventListener('click', (event) => {
    const chip = event.target.closest('[form-prefill]');
    if (!chip) return;

    const textarea = document.querySelector('textarea[name="prompt"]');
    if (textarea) {
        textarea.value = chip.dataset.prompt ?? '';
        textarea.focus();
        textarea.dispatchEvent(new Event('input', { bubbles: true }));
    }
});
