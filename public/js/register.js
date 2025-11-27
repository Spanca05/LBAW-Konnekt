document.getElementById('role').addEventListener('change', function () {
    const skillsWrapper = document.getElementById('skills-wrapper');
    skillsWrapper.style.display = this.value === 'JobSeeker' ? 'block' : 'none';
});

document.addEventListener('DOMContentLoaded', () => {
    const event = new Event('change');
    document.getElementById('role').dispatchEvent(event);
});
