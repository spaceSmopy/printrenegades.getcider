<?php

  namespace WebpConverter\Action;

  class _Core
  {
    public function __construct()
    {
      new Convert();
      new Delete();
    }
  }