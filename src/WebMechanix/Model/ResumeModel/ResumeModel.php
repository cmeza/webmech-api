<?php

namespace WebMechanix\Model\ResumeModel;

use WebMechanix\Model\ModelAbstract;

class ResumeModel extends ModelAbstract
{
  protected $data;

  function __construct()
  {
    parent::__construct();

    $file = fopen($this->config->resumeFile->json, 'r');
    $this->data = json_decode(fread($file, filesize($this->config->resumeFile->json)));
  }

  /**
   * Returns the resume summary data
   *
   * @return \stdClass
   */
  public function getSummary()
  {
    $summary = $this->data->resume;

    unset($summary->jobs);

    return $summary;
  }

  /**
   * Returns all the jobs
   *
   * @return array
   */
  public function getJobs()
  {
    $jobs = $this->data->resume->jobs;

    return $jobs;
  }

  /**
   * Gets the specific job by ID
   *
   * @param int $job_id
   * @return bool|array
   */
  public function getJobDetail($job_id = 0)
  {
    if ($job_id == 0) return false;

    $jobs = $this->data->resume->jobs;

    $job = $this->findInJobsArray($jobs, $job_id);

    return $job;
  }


  /**
   * Gets the specific job out of the array of jobs
   *
   * @param $jobs
   * @param $job_id
   * @return bool|\stdClass
   */
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
