<?php

  namespace WebpConverter\Convert;

  class Server
  {
    /* ---
      Functions
    --- */

    public function setSettings()
    {
      ini_set('memory_limit', '1G');

      if (strpos(ini_get('disable_functions'), 'set_time_limit') === false) {
        set_time_limit(120);
      }
    }
  }