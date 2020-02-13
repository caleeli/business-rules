<?php

namespace ProcessMaker\Package\BusinessRules\Models;

use ProcessMaker\Contracts\AssignmentRuleInterface;
use ProcessMaker\Models\Process;
use ProcessMaker\Models\ProcessRequest;
use ProcessMaker\Nayra\Contracts\Bpmn\ActivityInterface;
use ProcessMaker\Nayra\Contracts\Bpmn\TokenInterface;

/**
 * Before a task is assigned, search the tokens table for a previously assigned
 * task and use that users id for the new assignment.
 *
 */
class HierarchyAssignmentRule implements AssignmentRuleInterface
{

    /**
     * Before a task is assigned, search the tokens table for a previously
     * assigned task and use that users id for the new assignment.
     *
     * @param ActivityInterface $task
     * @param TokenInterface $token
     * @param Process $process
     * @param ProcessRequest $request
     * @return type
     */
    public function getNextUser(ActivityInterface $task, TokenInterface $token, Process $process, ProcessRequest $request)
    {
        return 1;
    }
}
