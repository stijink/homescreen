<?php

require __DIR__.'/../vendor/autoload.php';

\VCR\VCR::configure()->enableLibraryHooks(['curl', 'stream_wrapper']);
\VCR\VCR::configure()->setCassettePath(__DIR__ . '/Fixtures');
