<?php

namespace ProcessMaker\Package\BusinessRules\Http\Controllers\Api;

use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ProcessMaker\Exception\HttpResponseException;
use ProcessMaker\Http\Controllers\Controller;
use ProcessMaker\Http\Resources\ApiCollection;
use ProcessMaker\Http\Resources\ApiResource;
use ProcessMaker\Models\ProcessRequest;
use ProcessMaker\Package\BusinessRules\Models\BusinessRule;
use Throwable;

class BusinessRuleController extends Controller
{
    /**
     * Get the list of records of a Business Rule
     *
     * @param Request $request
     *
     * @return ApiCollection
     *
     * @OA\Get(
     *     path="/business_rules",
     *     summary="Returns all Business Rules that the user has access to",
     *     operationId="getBusinessRules",
     *     tags={"Business Rules"},
     *     @OA\Parameter(ref="#/components/parameters/filter"),
     *     @OA\Parameter(ref="#/components/parameters/order_by"),
     *     @OA\Parameter(ref="#/components/parameters/order_direction"),
     *     @OA\Parameter(ref="#/components/parameters/per_page"),
     *     @OA\Parameter(ref="#/components/parameters/include"),
     *
     *     @OA\Response(
     *         response=200,
     *         description="list of Business Rules",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/businessRule"),
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 allOf={@OA\Schema(ref="#/components/schemas/metadata")},
     *             ),
     *         ),
     *     ),
     * )
     */
    public function index(Request $request)
    {
        $query = BusinessRule::query();

        $include = $request->input('include', '');

        if ($include) {
            $include = explode(',', $include);
            if ($include) {
                $query->with($include);
            }
        }

        $filter = $request->input('filter', '');

        if (!empty($filter)) {
            $filter = '%' . $filter . '%';
            $query->where(function ($query) use ($filter) {
                $query->where('variable', 'like', $filter)
                    ->orWhere('condition', 'like', $filter);
            });
        }
        $response =
            $query->orderBy(
                $request->input('order_by', 'id'),
                $request->input('order_direction', 'ASC')
            )->paginate($request->input('per_page', 10));

        return new ApiCollection($response);
    }

    /**
     * Get a single Business Rule.
     *
     * @param BusinessRule $businessRule
     *
     * @return ApiResource
     *
     * @OA\Get(
     *     path="/business_rules/business_rule_id",
     *     summary="Get single Business Rule by ID",
     *     operationId="getBusinessRuleById",
     *     tags={"Business Rules"},
     *     @OA\Parameter(
     *         description="ID of Business Rule to return",
     *         in="path",
     *         name="business_rule_id",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully found the Business Rule",
     *         @OA\JsonContent(ref="#/components/schemas/businessRule")
     *     ),
     * )
     */
    public function show(BusinessRule $businessRule)
    {
        return new ApiResource($businessRule);
    }

    /**
     * Create a new Business Rule.
     *
     * @param Request $request
     *
     * @return ApiResource
     *
     * @throws Throwable
     *
     * @OA\Post(
     *     path="/business_rules",
     *     summary="Save a new Business Rule",
     *     operationId="createBusinessRule",
     *     tags={"Business Rules"},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/businessRuleEditable")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="success",
     *         @OA\JsonContent(ref="#/components/schemas/businessRule")
     *     ),
     * )
     */
    public function store(Request $request)
    {
        $request->validate(BusinessRule::rules());

        $businessRule = new BusinessRule;
        $businessRule->fill($request->input());
        $businessRule->saveOrFail();
        return new ApiResource($businessRule);
    }

    /**
     * Update a Business Rule.
     *
     * @param BusinessRule $businessRule
     * @param Request $request
     *
     * @return ResponseFactory|Response
     *
     * @throws Throwable
     *
     * @OA\Put(
     *     path="/business_rules/business_rule_id",
     *     summary="Update a Business Rule",
     *     operationId="updateBusinessRule",
     *     tags={"Business Rules"},
     *     @OA\Parameter(
     *         description="ID of Business Rule to return",
     *         in="path",
     *         name="business_rule_id",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/businessRuleEditable")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="success",
     *         @OA\JsonContent(ref="#/components/schemas/businessRule")
     *     ),
     * )
     */
    public function update(BusinessRule $businessRule, Request $request)
    {
        $request->validate(BusinessRule::rules($businessRule));
        $businessRule->fill($request->input());
        $businessRule->saveOrFail();

        return response([], 204);
    }

    /**
     * Delete a Business Rule.
     *
     * @param BusinessRule $businessRule
     *
     * @return ResponseFactory|Response
     *
     * @throws Exception
     *
     * @OA\Delete(
     *     path="/business_rules/business_rule_id",
     *     summary="Delete a Business Rule",
     *     operationId="deleteBusinessRule",
     *     tags={"Business Rules"},
     *     @OA\Parameter(
     *         description="ID of Business Rule to return",
     *         in="path",
     *         name="business_rule_id",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="success",
     *         @OA\JsonContent(ref="#/components/schemas/businessRule")
     *     ),
     * )
     */
    public function destroy(BusinessRule $businessRule)
    {
        $businessRule->delete();
        return response([], 204);
    }

}
