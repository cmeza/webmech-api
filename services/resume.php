<?php

$app->group('/resume', function() use ($app) {
  $app->get('/detail/:job_id', function($job_id = 0) use ($app) {
    $resume = new \API\Resume\Resume();

    echo json_encode(
        $resume->details($job_id)
    );
  });

  $app->get('/jobs', function() use ($app) {
    $resume = new \API\Resume\Resume();

    echo json_encode(
        $resume->jobs()
    );
  });
});