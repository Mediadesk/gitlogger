<?php

namespace Mediadesk\GitLogger\Utils;

use Exception;
use Illuminate\Http\Request;
abstract class BaseLogger
{
    protected $branch_name;

    protected $committed_at;

    protected $email;

    protected $commit_message;

    protected $commit_link;

    protected $repository_url, $repository_path, $repository_name;

    protected $call_back_data;

    protected $webhook_url;

    protected $domain;

    protected $service;

    protected $commit_log;

    protected $is_private = false;

    public function __construct(Request $request)
    {
        $this->call_back_data = $request->all();
        $this->webhook_url    = $request->fullUrl();
    }


    protected function setPayloadInfo(): self
    {
        $this->commit_log  = $this->getNewLogs(); //set git change logs in memory

        $this->setEmail();
        $this->setRepositoryUrl();
        $this->setRepositoryPath();
        $this->setCommitMessage();
        $this->setCommitLink();
        $this->setBranchName();
        $this->setCommittedAt();
        $this->setIsPrivate();
        $this->setRepositoryName();
        
        return $this;
    }


    protected abstract function getNewLogs(): array|null;
    protected abstract function validateRequest(): bool;
    
    protected abstract function setBranchName(): void;
    protected abstract function setCommittedAt(): void;
    protected abstract function setEmail(): void;
    protected abstract function setCommitMessage(): void;
    protected abstract function setCommitLink(): void;
    protected abstract function setRepositoryUrl(): void;
    protected abstract function setRepositoryPath(): void;
    protected abstract function setIsPrivate(): void;
    protected abstract function setRepositoryName(): void;


    /**
     * @return $this
     * @throws Exception If an error occurs during the start process.
     */

     public function start(): self
    {
        if($this->validateRequest())
        {
            return $this->setPayloadInfo();
        }

         throw new Exception("Request validation failed.");
    }

    protected function getAuthorEmail(): string|null
    {
        return $this->email;
    }


    protected function getCommitMessage(): string|null
    {
        return $this->commit_message;
    }

    protected function getBranch(): string|null
    {
        return $this->branch_name;
    }


    protected function getCommitLink(): string|null
    {
        return $this->commit_link;
    }

    protected function getCommitDate(): string|null
    {
        return $this->committed_at;
    }

    protected function getRepositoryPath(): string|null
    {
        return $this->repository_path;
    }


    protected function getRepositoryLink(): string|null
    {
        return $this->repository_url;
    }


    protected function getIsPrivate(): bool
    {
        return $this->is_private;
    }


    public function get(): array
    {
        $this->start();

        $data = [];
        $data['branch']              = $this->branch_name;
        $data['committed_at']        = $this->committed_at;
        $data['email']               = $this->email;
        $data['commit_message']      = $this->commit_message;
        $data['commit_link']         = $this->commit_link;
        $data['repository_url']      = $this->repository_url;
        $data['repository_path']     = $this->repository_path;
        $data['repository_name']     = $this->repository_name;
        $data['service']             = $this->service;
        $data['domain']              = $this->domain;
        $data['private']             = $this->is_private;
        return $data;
    }

}
