<?php

namespace API\Resume;

use API\API;

class Resume extends API
{
  private $resume_data;

  function __construct()
  {
    parent::__construct();

    $file = fopen($this->config->resumeFile, 'r');

    $this->resume_data = json_decode(fread($file, filesize($this->config->resumeFile)));
  }

  public function details($job_id = 0)
  {
    $jobs = $this->resume_data->resume->jobs;

    $job = $this->findInJobsArray($jobs, $job_id);

    return $job;
  }

  public function jobs()
  {
    $jobs = $this->resume_data->resume->jobs;
    return $jobs;
  }



  private function findInJobsArray($jobs, $job_id)
  {
    $found = false;

    foreach ($jobs as $job) {
      if ($job->id == $job_id) {
        $found = $job;
        break;
      }
    }

    return $found;
  }
}