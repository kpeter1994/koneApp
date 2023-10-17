

export function formatDate(date) {
    const d = new Date(date)
    const ev = d.getFullYear();
    const ho = (d.getMonth() + 1).toString().padStart(2, '0'); // A hónapok 0-tól indexeltek, ezért +1, majd két karakter hosszúságúvá alakítjuk
    const nap = d.getDate().toString().padStart(2, '0');

    return `${ev}.${ho}.${nap}`;
}

export function formatTime(date) {
    const d = new Date(date)
    const ora = d.getHours().toString().padStart(2, '0'); // Az órát két karakter hosszúvá alakítjuk
    const perc = d.getMinutes().toString().padStart(2, '0'); // A percet két karakter hosszúvá alakítjuk

    return `${ora}:${perc}`;
}
