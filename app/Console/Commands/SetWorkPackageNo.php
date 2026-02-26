<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExpeditingContext;

class SetWorkPackageNo extends Command
{
    protected $signature = 'expediting:set-work-package-no {context_id} {identifier}';
    protected $description = 'Set the Work Package No. (identifier) for a given expediting_contexts record';

    public function handle()
    {
        $contextId = $this->argument('context_id');
        $identifier = $this->argument('identifier');
        $context = ExpeditingContext::find($contextId);
        if (!$context) {
            $this->error('Context not found.');
            return 1;
        }
        $context->identifier = $identifier;
        $context->save();
        $this->info("Work Package No. updated for context_id {$contextId}.");
        return 0;
    }
}
