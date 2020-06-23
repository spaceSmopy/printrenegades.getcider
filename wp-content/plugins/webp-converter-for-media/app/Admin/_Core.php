<?php

  namespace WebpConverter\Admin;

  class _Core
  {
    public function __construct()
    {
      new Activation();
      new Assets();
      new Deactivation();
      new Notice();
      new Plugin();
      new Uninstall();
      new Update();
    }
  }