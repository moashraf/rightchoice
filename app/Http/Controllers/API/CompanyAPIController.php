<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCompanyAPIRequest;
use App\Http\Requests\API\UpdateCompanyAPIRequest;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppBaseController;

/**
 * Class CompanyController
 * @package App\Http\Controllers\API
 */

class CompanyAPIController extends AppBaseController
{
    /** @var  CompanyRepository */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepo)
    {
        $this->companyRepository = $companyRepo;
    }

    /**
     * Display a listing of the Company.
     * GET|HEAD /companies
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $companies = $this->companyRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($companies->toArray(), 'Companies retrieved successfully');
    }

    /**
     * Get companies by service ID with pagination.
     * POST /companies/by-service/{serviceId}?per_page=10&page=1
     */
    public function getByService(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|integer|exists:services,id',
            'per_page'   => 'nullable|integer|min:1|max:100',
        ], [
            'service_id.required' => 'حقل service_id مطلوب',
            'service_id.integer'  => 'service_id يجب أن يكون رقماً صحيحاً',
            'service_id.exists'   => 'الخدمة المطلوبة غير موجودة',
            'per_page.integer'    => 'per_page يجب أن يكون رقماً صحيحاً',
            'per_page.min'        => 'per_page يجب أن يكون على الأقل 1',
            'per_page.max'        => 'per_page يجب ألا يتجاوز 100',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة', 422, $validator->errors()->toArray());
        }

        $serviceId = $request->input('service_id');
        $perPage   = $request->input('per_page', 15);

        $companies = Company::where('Serv_id', $serviceId)
            ->with(['serv', 'governrateq', 'subArea'])
            ->paginate($perPage);

        return $this->sendResponse($companies->toArray(), 'Companies retrieved successfully');
    }

    /**
     * Store a newly created Company in storage.
     * POST /companies
     *
     * @param CreateCompanyAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCompanyAPIRequest $request): JsonResponse
    {
        try {
            $input = $request->all();
            $company = $this->companyRepository->create($input);

            return $this->sendResponse(
                $company->load(['serv', 'governrateq', 'district_ashraf', 'subArea'])->toArray(),
                'Company saved successfully'
            );
        } catch (\Exception $e) {
            return $this->sendError('Failed to create company: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified Company.
     * GET|HEAD /companies/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Company $company */
        $company = $this->companyRepository->find($id);

        if (empty($company)) {
            return $this->sendError('Company not found');
        }

        return $this->sendResponse($company->toArray(), 'Company retrieved successfully');
    }

    /**
     * Update the specified Company in storage.
     * PUT/PATCH /companies/{id}
     *
     * @param int $id
     * @param UpdateCompanyAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompanyAPIRequest $request)
    {
        $input = $request->all();

        /** @var Company $company */
        $company = $this->companyRepository->find($id);

        if (empty($company)) {
            return $this->sendError('Company not found');
        }

        $company = $this->companyRepository->update($input, $id);

        return $this->sendResponse($company->toArray(), 'Company updated successfully');
    }

    /**
     * Remove the specified Company from storage.
     * DELETE /companies/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Company $company */
        $company = $this->companyRepository->find($id);

        if (empty($company)) {
            return $this->sendError('Company not found');
        }

        $company->delete();

        return $this->sendSuccess('Company deleted successfully');
    }
}
