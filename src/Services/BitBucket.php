<?php

namespace Mediadesk\GitLogger\Services;

use Mediadesk\GitLogger\Contracts\LoggingContracts;
use Mediadesk\GitLogger\Utils\BaseLogger;
use Exception;
use Illuminate\Http\Request;

class BitBucket extends BaseLogger implements LoggingContracts
{
    protected $domain = 'bitbucket.org';

    protected $service = 'github';

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Get an array of new log entries from the Git logging API.
     *
     * @return array|null An array of new log entries.
     */

    public function getNewLogs(): array|null
    {
        if(!isset($this->call_back_data['push'])){
            return null;
        }

        $push = $this->call_back_data['push'];

        if(!isset($push['changes'])){
            return null;
        }

        $changes = $push['changes'];

        if(!count($changes)){
            return null;
        }

        if(!isset($changes[0]['new']))
        {
            return null;
        }

        return $changes[0]['new'];
    }

     /**
     * Validate the incoming request from the Git logging API.
     *
     * @return bool True if the request is valid, false otherwise.
     */
    public function validateRequest(): bool
    {
        if(!is_array($this->getNewLogs()))
        {
            throw new Exception("Invalid git payload", 500);
        }

        $domain    = parse_url($this->call_back_data['repository']['links']['html']['href'], PHP_URL_HOST);

        if($domain == $this->domain)
        {
            return true;
        }

        throw new Exception("Not a valid $this->service payload", 500);
    }

    /**
     * Set the branch name for the log entry.
     *
     * @return void
     */
    public function setBranchName(): void
    {
        $this->branch_name = $this->commit_log['name'];;
    }

    /**
     * Set the committed at timestamp for the log entry.
     *
     * @return void
     */
    public function setCommittedAt(): void
    {
        $this->committed_at = $this->commit_log['target']['date'];
    }

    /**
     * Set the email associated with the log entry.
     *
     * @return void
     */
    public function setEmail(): void
    {
        preg_match_all("/\<([^\]]*)\>/", $this->commit_log['target']['author']['raw'], $matches);

        $this->email = $matches[1][0];
    }


    /**
     * Set the commit message for the log entry.
     *
     * @return void
     */
    public function setCommitMessage(): void
    {
        $this->commit_message = $this->commit_log['target']['message'];
    }

    /**
     * Set the link to the commit for the log entry.
     *
     * @return void
     */
    public function setCommitLink(): void
    {
        $this->commit_link = $this->commit_log['target']['links']['html']['href'];
    }

    /**
     * Set the repository URL for the log entry.
     *
     * @return void
     */
    public function setRepositoryUrl(): void
    {
        $this->repository_url = $this->call_back_data['repository']['links']['html']['href'];
    }


    /**
     * Set the repository path for the log entry.
     *
     * @return void
     */
    public function setRepositoryPath(): void
    {
        $this->repository_path = $this->call_back_data['repository']['full_name'];
    }


    /**
     * Set whether the repository is private for the log entry.
     *
     * @return void
     */
    public function setIsPrivate(): void
    {
        $this->is_private = $this->call_back_data['repository']['is_private'];
    }


    /**
     * Set the repository name for the log entry.
     *
     * @return void
     */
    public function setRepositoryName(): void
    {
        $this->repository_name = $this->call_back_data['repository']['name'];
    }

}
