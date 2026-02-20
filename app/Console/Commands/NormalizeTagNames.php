<?php

namespace App\Console\Commands;

use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NormalizeTagNames extends Command
{
    protected $signature = 'tags:normalize-names
                            {--dry-run : Show what would be changed without writing to the database}';

    protected $description = 'Normalize existing tag names to lowercase snake_case (spaces to underscores). Merges duplicates.';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        if ($dryRun) {
            $this->warn('Dry run: no changes will be written.');
        }

        $tags = Tag::all();
        if ($tags->isEmpty()) {
            $this->info('No tags found.');

            return self::SUCCESS;
        }

        $groups = [];
        foreach ($tags as $tag) {
            $normalized = Tag::normalizeName($tag->name);
            $groups[$normalized][] = $tag;
        }

        $updated = 0;
        $merged = 0;
        $deleted = 0;

        DB::beginTransaction();
        try {
            foreach ($groups as $normalizedName => $groupTags) {
                $keep = $groupTags[0];
                $others = array_slice($groupTags, 1);

                if ($keep->name !== $normalizedName) {
                    $oldName = $keep->name;
                    if (! $dryRun) {
                        $keep->update(['name' => $normalizedName]);
                    }
                    $updated++;
                    $this->line("  Normalize: \"{$oldName}\" → \"{$normalizedName}\"");
                }

                foreach ($others as $other) {
                    $merged++;
                    $this->line("  Merge: \"{$other->name}\" into \"{$normalizedName}\" (tag id {$keep->id})");
                    if (! $dryRun) {
                        $itemIds = $other->items->pluck('id')->all();
                        $keep->items()->syncWithoutDetaching($itemIds);
                        $other->delete();
                        $deleted++;
                    }
                }
            }

            if ($dryRun) {
                DB::rollBack();
                $this->newLine();
                $this->info("Would update {$updated} tag(s), merge {$merged} duplicate(s). Run without --dry-run to apply.");
            } else {
                DB::commit();
                $this->newLine();
                $this->info("Updated {$updated} tag(s), merged {$merged} duplicate(s), deleted {$deleted} tag(s).");
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
