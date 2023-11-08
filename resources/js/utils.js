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

export class formater {
    static formatDate(date) {
        const now = new Date();
        const inputDate = new Date(date);
        const diffInSeconds = Math.floor((now - inputDate) / 1000);

        // Ha kevesebb mint egy óra telt el
        if (diffInSeconds < 3600) {
            return `${Math.floor(diffInSeconds / 60)} perce`;
        }

        // Ha kevesebb mint egy nap telt el
        if (diffInSeconds < 86400) {
            return `${Math.floor(diffInSeconds / 3600)} órája`;
        }

        // Ha több mint egy nap telt el, dátum formátumban adjuk vissza
        const day = inputDate.getDate().toString().padStart(2, '0');
        const month = (inputDate.getMonth() + 1).toString().padStart(2, '0');
        const year = inputDate.getFullYear();

        return `${year}-${month}-${day}`;
    }

    static getMonogram(name) {
        if (name === null || name === 'NULL') {
            return ''; // Vagy visszatérhetünk valamilyen alapértelmezett értékkel
        }
        // Segédfüggvény a monogram készítéséhez
        function extractInitial(part) {
            if (part.startsWith('Cs') || part.startsWith('Sz') || part.startsWith('Zs')) {
                return part.slice(0, 2).toUpperCase();
            }
            return part[0].toUpperCase();
        }

        const parts = name.split(' ');

        if (parts.length === 1) {
            // Ha csak egy szó van, akkor csak az első betűt adjuk vissza.
            return extractInitial(parts[0]);
        } else {
            const vezetekNev = parts[0] || '';
            const keresztNev = parts[1] || '';
            return `${extractInitial(vezetekNev)}${extractInitial(keresztNev)}`;
        }
    }


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

export function isDutyTime(){
    const holidays = [
        '01-01',
        '03-15',
        '05-01',
        '08-20',
        '10-23',
        '11-01',
        '12-24',
        '12-25',
        '12-26',
        '12-27',
        '12-28',
        '12-29',
        '12-30',
        '12-31'
    ]
    const now = new Date();
    const month = String(now.getMonth() + 1).padStart(2, '0'); // Hónapok 0-tól kezdődnek JavaScriptben, ezért hozzáadunk 1-et
    const day = String(now.getDate()).padStart(2, '0');
    const today = `${month}-${day}`;
    const dayOfWeek = now.getDay();
    const currentHour  = now.getHours();

    if (holidays.includes(today)) {
        return true;
    }

    if (dayOfWeek === 0 || dayOfWeek === 6) {
        return true;
    }

    if (dayOfWeek === 5 && currentHour >= 14) {
        return true;
    }

    if (currentHour < 8 || currentHour >= 16) {
        return true;
    }

}


