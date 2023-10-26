import axios from "axios";


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


export async function geocodeAddress(address) {
    const baseUrl = 'https://nominatim.openstreetmap.org/search';

    async function fetchCoordinates(query) {
        const params = {
            q: query,
            format: 'json',
            limit: 1
        };

        const response = await axios.get(baseUrl, { params });
        if (response.data && response.data.length > 0) {
            return response.data[0];
        }
        return null;
    }

    let location = await fetchCoordinates(address);

    // Ellenőrizzük, hogy az eredmény tartalmazza-e az address utolsó szavát
    if (!location || !location.display_name.includes(address.split(" ").pop())) {
        const firstWord = address.split(" ")[0];
        const lastWord = address.split(" ").pop();
        const reducedAddress = `${firstWord} ${lastWord}`;
        location = await fetchCoordinates(reducedAddress);
    }

    if (location) {
        return {
            lat: parseFloat(location.lat),
            lon: parseFloat(location.lon)
        };
    } else {
        throw new Error('Cím nem található');
    }
}


