<?php

namespace WebMechanix\API\Resume;

use WebMechanix\API\ApiAbstract;
use WebMechanix\Model\ResumeModel\ResumeModel;

class Resume extends ApiAbstract
{
  private $resumeModel;

  function __construct()
  {
    parent::__construct();

    $this->resumeModel = $this->getResumeModel();
  }

  /**
   * Get a specific job by ID
   *
   * @param int $job_id
   * @return array|bool
   */
  public function details($job_id = 0)
  {
    if ($job_id == 0) $this->throwError('JOB_ID IS REQUIRED');

    $job = $this->resumeModel->getJobDetail($job_id);

    return $job;
  }

  /**
   * Get all the jobs with full job detail or job summary if $summary is true
   *
   * @param bool|false $summary
   * @return array
   */
  public function jobs($summary = false)
  {
    $jobs = $this->resumeModel->getJobs();

    if ($summary) $jobs = $this->getMinimumJobDetails($jobs);

    return $jobs;
  }

  /**
   * Gets the resume summary
   *
   * @return \stdClass
   */
  public function summary()
  {
    $summary = $this->resumeModel->getSummary();

    return $summary;
  }

  /**
   * Load the latest resume docx file from local
   *
   * @param $email
   * @return \stdClass
   */
  public function file($email)
  {
    $file = readfile($this->config->resumeFile->docx);

//    $response = new \stdClass();
//    $response->file     = $file;
//    $response->fileDate = $this->config->resumeDate;

    $this->trackEmail($email, $this->config->resumeDate);

    return $file;
  }


  /**
   * Gets the ResumeModel
   *
   * @return ResumeModel
   */
  private function getResumeModel()
  {
    $resumeModel = new ResumeModel();

    return $resumeModel;
  }

  /**
   * Take the full job detail response & get just the summary content
   *
   * @param $jobs
   * @return array
   */
  private function getMinimumJobDetails($jobs)
  {
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

    return $minJobs;
  }

  private function trackEmail($email, $date)
  {
    // add to db
  }
}
