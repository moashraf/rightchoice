<?php

namespace App\Http\Controllers;

use App\DataTables\property_typeDataTable;
use App\Http\Requests;
use App\Http\Requests\Createproperty_typeRequest;
use App\Http\Requests\Updateproperty_typeRequest;
use App\Models\property_type;
use App\Repositories\property_typeRepository;
use App\Services\ModelService;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;
use App\Models\aqar_category;
class property_typeController extends AppBaseController
{
    /** @var  property_typeRepository */
    private $propertyTypeRepository;

    public function __construct(property_typeRepository $propertyTypeRepo)
    {
        $this->propertyTypeRepository = $propertyTypeRepo;
    }

    /**
     * Display a listing of the property_type.
     *
     * @param property_typeDataTable $propertyTypeDataTable
     * @return Response
     */
    public function index(Request $request)
    {
        $property_types = property_type::query();
        $property_types = ModelService::filter_search($property_types,'property_type',$request);

        return view('property_types.index',compact('property_types'));
    }

    /**
     * Show the form for creating a new property_type.
     *
     * @return Response
     */
    public function create()
    {
        $category = aqar_category::pluck('category_name', 'id');
        return view('property_types.create',compact('category'));
    }

    /**
     * Store a newly created property_type in storage.
     *
     * @param Createproperty_typeRequest $request
     *
     * @return Response
     */
    public function store(Createproperty_typeRequest $request)
    {
        $input = $request->all();

        $propertyType = $this->propertyTypeRepository->create($input);

        Flash::success('Property Type saved successfully.');

        return redirect(route('propertyTypes.index'));
    }

    /**
     * Display the specified property_type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $propertyType = $this->propertyTypeRepository->find($id);

        if (empty($propertyType)) {
            Flash::error('Property Type not found');

            return redirect(route('propertyTypes.index'));
        }

        return view('property_types.show')->with('propertyType', $propertyType);
    }

    /**
     * Show the form for editing the specified property_type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $propertyType = $this->propertyTypeRepository->find($id);

        if (empty($propertyType)) {
            Flash::error('Property Type not found');

            return redirect(route('propertyTypes.index'));
        }
        $category = aqar_category::pluck('category_name', 'id');
        return view('property_types.edit',compact('category'))->with('propertyType', $propertyType);
    }

    /**
     * Update the specified property_type in storage.
     *
     * @param  int              $id
     * @param Updateproperty_typeRequest $request
     *
     * @return Response
     */
    public function update($id, Updateproperty_typeRequest $request)
    {
        $propertyType = $this->propertyTypeRepository->find($id);

        if (empty($propertyType)) {
            Flash::error('Property Type not found');

            return redirect(route('propertyTypes.index'));
        }

        $propertyType = $this->propertyTypeRepository->update($request->all(), $id);

        Flash::success('Property Type updated successfully.');

        return redirect(route('propertyTypes.index'));
    }

    /**
     * Remove the specified property_type from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $propertyType = $this->propertyTypeRepository->find($id);

        if (empty($propertyType)) {
            Flash::error('Property Type not found');

            return redirect(route('propertyTypes.index'));
        }

        $this->propertyTypeRepository->delete($id);

        Flash::success('Property Type deleted successfully.');

        return redirect(route('propertyTypes.index'));
    }
}
