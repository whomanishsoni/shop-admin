<?php

namespace App\Console\Commands;

use App\Models\ShippingZone;
use Illuminate\Console\Command;

class FixShippingZoneStates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-shipping-zone-states';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert full state names to codes in the states column of the shipping_zones table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing states in shipping_zones table...');

        // Mapping of full state names to codes
        $indianStates = [
            'Andaman and Nicobar Islands' => 'AN',
            'Andhra Pradesh' => 'AP',
            'Arunachal Pradesh' => 'AR',
            'Assam' => 'AS',
            'Bihar' => 'BR',
            'Chandigarh' => 'CH',
            'Chhattisgarh' => 'CT',
            'Delhi' => 'DL',
            'Dadra and Nagar Haveli and Daman and Diu' => 'DN',
            'Goa' => 'GA',
            'Gujarat' => 'GJ',
            'Himachal Pradesh' => 'HP',
            'Haryana' => 'HR',
            'Jharkhand' => 'JH',
            'Jammu and Kashmir' => 'JK',
            'Karnataka' => 'KA',
            'Kerala' => 'KL',
            'Ladakh' => 'LA',
            'Lakshadweep' => 'LD',
            'Maharashtra' => 'MH',
            'Meghalaya' => 'ML',
            'Manipur' => 'MN',
            'Madhya Pradesh' => 'MP',
            'Mizoram' => 'MZ',
            'Nagaland' => 'NL',
            'Odisha' => 'OR',
            'Punjab' => 'PB',
            'Puducherry' => 'PY',
            'Rajasthan' => 'RJ',
            'Sikkim' => 'SK',
            'Tamil Nadu' => 'TN',
            'Telangana' => 'TG',
            'Tripura' => 'TR',
            'Uttar Pradesh' => 'UP',
            'Uttarakhand' => 'UT',
            'West Bengal' => 'WB',
        ];

        $zones = ShippingZone::all();
        $fixedCount = 0;

        foreach ($zones as $zone) {
            // Decode states (handles both JSON strings and arrays due to model casting)
            $states = is_string($zone->states) ? json_decode($zone->states, true) : $zone->states;

            if (!is_array($states)) {
                $this->warn("Invalid JSON for zone ID: {$zone->id}, states: {$zone->states}");
                continue;
            }

            // Convert full state names to codes
            $convertedStates = array_map(function ($state) use ($indianStates) {
                return $indianStates[$state] ?? $state;
            }, $states);

            // Filter for valid state codes
            $validStates = array_filter($convertedStates, fn($code) => in_array($code, array_values($indianStates)));

            // Only update if the states have changed
            if ($states !== $validStates) {
                $zone->states = $validStates; // Model casting will encode as JSON
                $zone->save();
                $this->info("Fixed zone ID: {$zone->id}, states: " . json_encode($validStates));
                $fixedCount++;
            } else {
                $this->line("No changes needed for zone ID: {$zone->id}");
            }
        }

        $this->info("Fixed {$fixedCount} shipping zones.");
    }
}
