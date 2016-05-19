<?php

$app->group('/resume', function() use ($app) {

  $app->get('/detail/:job_id', function($job_id = 0) use ($app) {
    $resume = new \WebMechanix\API\Resume\Resume();

    echo json_encode(
        $resume->details($job_id)
    );
  });

  $app->get('/jobs', function() use ($app) {
    $resume = new \WebMechanix\API\Resume\Resume();

    echo json_encode(
        $resume->jobs(false)
    );
  });

  $app->get('/jobs/min', function() use ($app) {
    $resume = new \WebMechanix\API\Resume\Resume();

    echo json_encode(
        $resume->jobs(true)
    );
  });
  
  $app->get('/summary', function() use ($app) {
    $resume = new \WebMechanix\API\Resume\Resume();
    
    echo json_encode(
        $resume->summary()
    );
  });
  
  $app->post('/file', function() use ($app) {
    $resume = new \WebMechanix\API\Resume\Resume();

    $email = $app->request->post('emailAddress');
    $resume->trackDownload($email);
    
    $app->response->header('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    $app->response->header('Content-Transfer-Encoding', 'binary');

    $file = $resume->file();
    
    echo $file;
  });
});
