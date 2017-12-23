<?php
    /**
     * Created by PhpStorm.
     * User: donyino
     * Date: 23/12/2017
     * Time: 7:37 AM
     */

    namespace App;


    use Illuminate\Support\Facades\Redis;

    trait RecordsVisits
    {

        public function recordVisit()
        {
            Redis::incr($this->visitsCacheKey());

            return $this;
        }

        public function visits()
        {
            return Redis::get($this->visitsCacheKey()) ?? 0;
        }

        public function resetVisits()
        {
            Redis::del($this->visitsCacheKey());

            return $this;
        }

        protected function visitsCacheKey()
        {
            return "threads. {$this->id}.visits";
        }
    }