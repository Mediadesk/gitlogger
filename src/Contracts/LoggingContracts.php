<?php

namespace Mediadesk\GitLogger\Contracts;

/**
 * Interface LoggingContracts
 * This interface defines methods for interacting with a Git logging API.
 */
interface LoggingContracts {

    /**
     * Get an array of new log entries from the Git logging API.
     *
     * @return array An array of new log entries.
     */
    public function getNewLogs(): array|null;

    /**
     * Validate the incoming request from the Git logging API.
     *
     * @return bool True if the request is valid, false otherwise.
     */
    public function validateRequest(): bool;

    /**
     * Set the branch name for the log entry.
     *
     * @return void
     */
    public function setBranchName(): void;

    /**
     * Set the committed at timestamp for the log entry.
     *
     * @return void
     */
    public function setCommittedAt(): void;

    /**
     * Set the email associated with the log entry.
     *
     * @return void
     */
    public function setEmail(): void;

    /**
     * Set the commit message for the log entry.
     *
     * @return void
     */
    public function setCommitMessage(): void;

    /**
     * Set the link to the commit for the log entry.
     *
     * @return void
     */
    public function setCommitLink(): void;

    /**
     * Set the repository URL for the log entry.
     *
     * @return void
     */
    public function setRepositoryUrl(): void;

    /**
     * Set the repository path for the log entry.
     *
     * @return void
     */
    public function setRepositoryPath(): void;

    /**
     * Set whether the repository is private for the log entry.
     *
     * @return void
     */
    public function setIsPrivate(): void;

    /**
     * Set the repository name for the log entry.
     *
     * @return void
     */
    public function setRepositoryName(): void;

    /**
     * Returns the git log results in an array
     *
     * @return array
     */

    public function get(): array;
}
