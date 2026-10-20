document.addEventListener('DOMContentLoaded', function () {
    const search=document.getElementById('search'), category=document.getElementById('category'), events=document.querySelectorAll('#events .card');
    function filterEvents() {
    const q=(search?.value||'').toLowerCase();
    const c=category?.value||'all';
    events.forEach(card=> {
    const text=card.textContent.toLowerCase();
    const matchesText=text.includes(q);
    const matchesCategory=c==='all'||text.includes(c.toLowerCase());
    card.style.display=matchesText&&matchesCategory?'':'none';
}
);
}
search?.addEventListener('input',filterEvents);
    category?.addEventListener('change',filterEvents);
}
);
