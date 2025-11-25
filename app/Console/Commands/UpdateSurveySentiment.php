<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Survey;

class UpdateSurveySentiment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:update-sentiment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update survey sentiment based on rating (Negative if < 2.5, Positive if > 4.0, otherwise Neutral)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating survey sentiments based on ratings...');
        
        $surveys = Survey::all();
        $updated = 0;
        
        foreach ($surveys as $survey) {
            $oldSentiment = $survey->sentiment;
            $newSentiment = $this->determineSentiment($survey->rating);
            
            if ($oldSentiment !== $newSentiment) {
                $survey->update(['sentiment' => $newSentiment]);
                $updated++;
                $this->line("Survey #{$survey->id}: Updated from '{$oldSentiment}' to '{$newSentiment}' (Rating: {$survey->rating})");
            }
        }
        
        $this->info("Completed! Updated {$updated} out of {$surveys->count()} surveys.");
        
        return Command::SUCCESS;
    }
    
    /**
     * Determine sentiment based on rating
     */
    private function determineSentiment(float $rating): string
    {
        if ($rating < 2.5) {
            return 'negative';
        } elseif ($rating > 4.0) {
            return 'positive';
        } else {
            return 'neutral';
        }
    }
}
