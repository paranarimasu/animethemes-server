<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\MissingValue;

class SearchResource extends BaseResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'search';

    /**
     * Create a new resource instance.
     *
     * @param mixed  $parser
     * @return void
     */
    public function __construct($parser)
    {
        parent::__construct(new MissingValue, $parser);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            AnimeCollection::$wrap => $this->when(
                $this->isAllowedField(AnimeCollection::$wrap),
                AnimeCollection::performSearch($this->parser)
            ),
            ArtistCollection::$wrap => $this->when(
                $this->isAllowedField(ArtistCollection::$wrap),
                ArtistCollection::performSearch($this->parser)
            ),
            EntryCollection::$wrap => $this->when(
                $this->isAllowedField(EntryCollection::$wrap),
                EntryCollection::performSearch($this->parser)
            ),
            SeriesCollection::$wrap => $this->when(
                $this->isAllowedField(SeriesCollection::$wrap),
                SeriesCollection::performSearch($this->parser)
            ),
            SongCollection::$wrap => $this->when(
                $this->isAllowedField(SongCollection::$wrap),
                SongCollection::performSearch($this->parser)
            ),
            SynonymCollection::$wrap => $this->when(
                $this->isAllowedField(SynonymCollection::$wrap),
                SynonymCollection::performSearch($this->parser)
            ),
            ThemeCollection::$wrap => $this->when(
                $this->isAllowedField(ThemeCollection::$wrap),
                ThemeCollection::performSearch($this->parser)
            ),
            VideoCollection::$wrap => $this->when(
                $this->isAllowedField(VideoCollection::$wrap),
                VideoCollection::performSearch($this->parser)
            ),
        ];
    }
}
