<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Equipment;
use App\Services\MapService;

class UpdateEquipmentsGeoLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-geolocation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $equipments = Equipment::all(); // Feltételezve, hogy az eszközök modellje 'Equipment' néven létezik.
        $mapService = new MapService();

        foreach ($equipments as $equipment) {
            $geoLocation = $mapService->getGeoLocation($equipment->address);
            if (isset($geoLocation['results'][0])) {
                $equipment->lat = $geoLocation['results'][0]['lat'];
                $equipment->lng = $geoLocation['results'][0]['lon'];
                $equipment->save();
            } else {
                // Ide írhat egy log bejegyzést vagy hibát, ha szükséges
                $this->error("No geolocation data found for address: " . $equipment->address);
            }
        }

        $this->info('Geolocation for all equipments has been updated.');
    }
}
