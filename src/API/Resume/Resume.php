<?php

namespace API\Resume;

use API\API;

class Resume extends API
{
  private $resume_data;

  function __construct()
  {
    parent::__construct();

    $this->resume_data = $this->getResumeData();
  }

  public function details($job_id = 0)
  {
    if ($job_id == 0) $this->throw_error('JOB_ID IS REQUIRED');

    $jobs = $this->resume_data->resume->jobs;

    $job = $this->findInJobsArray($jobs, $job_id);

    return $job;
  }

  public function jobs($minimum = false)
  {
    $jobs = $this->resume_data->resume->jobs;

    if ($minimum) {
      $minJobs = [];

      foreach ($jobs as $job) {
        $minJob = [
            'id'        => $job->id,
            'dateStart' => $job->dateStart,
            'dateEnd'   => $job->dateEnd,
            'title'     => $job->title,
            'company'   => [
                'name'     => $job->company->name,
                'location' => $job->company->location
            ]
        ];

        $minJobs[] = $minJob;
      }

      $jobs = $minJobs;
    }

    return $jobs;
  }

  public function summary()
  {
    $resume = $this->resume_data->resume;

    unset($resume->jobs);

    return $resume;
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

  private function getResumeData()
  {
    $file = fopen($this->config->resumeFile, 'r');
    $resume_data = json_decode(fread($file, filesize($this->config->resumeFile)));

    return $resume_data;
  }
}