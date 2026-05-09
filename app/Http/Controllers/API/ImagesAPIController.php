<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateImagesAPIRequest;
use App\Http\Requests\API\UpdateImagesAPIRequest;
use App\Models\Images;
use App\Repositories\ImagesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Response;

/**
 * Class ImagesController
 * @package App\Http\Controllers\API
 */

class ImagesAPIController extends AppBaseController
{
    /** @var  ImagesRepository */
    private $imagesRepository;

    public function __construct(ImagesRepository $imagesRepo)
    {
        $this->imagesRepository = $imagesRepo;
    }

    /**
     * Display a listing of the Images.
     * GET|HEAD /images
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $images = $this->imagesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($images->toArray(), 'Images retrieved successfully');
    }

    /**
     * Store a newly created Images in storage.
     * POST /images
     *
     * @param CreateImagesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateImagesAPIRequest $request)
    {
        $input = $request->all();

        $images = $this->imagesRepository->create($input);

        return $this->sendResponse($images->toArray(), 'Images saved successfully');
    }

    /**
     * Display the specified Images.
     * GET|HEAD /images/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Images $images */
        $images = $this->imagesRepository->find($id);

        if (empty($images)) {
            return $this->sendError('Images not found');
        }

        return $this->sendResponse($images->toArray(), 'Images retrieved successfully');
    }

    /**
     * Update the specified Images in storage.
     * PUT/PATCH /images/{id}
     *
     * @param int $id
     * @param UpdateImagesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateImagesAPIRequest $request)
    {
        $input = $request->all();

        /** @var Images $images */
        $images = $this->imagesRepository->find($id);

        if (empty($images)) {
            return $this->sendError('Images not found');
        }

        $images = $this->imagesRepository->update($input, $id);

        return $this->sendResponse($images->toArray(), 'Images updated successfully');
    }

    /**
     * Remove the specified Images from storage.
     * DELETE /images/{id}
     *
     * @param int $id
     * @param Request $request  (required: aqar_id)
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {

        // aqar_id is required
        $validator = Validator::make($request->all(), [
            'aqar_id' => 'required|integer',
        ], [
            'aqar_id.required' => 'رقم العقار مطلوب',
            'aqar_id.integer'  => 'رقم العقار يجب أن يكون رقماً صحيحاً',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

         // Validate that the image id is a valid integer
        if (!is_numeric($id) || (int)$id <= 0) {
            return $this->sendError('رقم الصورة غير صالح، يجب أن يكون رقماً صحيحاً موجباً');
        }

        /** @var Images $images */
        $images = $this->imagesRepository->find($id);

        if (empty($images)) {
            return $this->sendError('لم يتم العثور على الصورة بهذا الرقم');
        }

        // Make sure the image belongs to the given aqar
        if ((int)$images->aqar_id !== (int)$request->aqar_id) {
             return $this->sendError('هذه الصورة لا تنتمي للعقار المحدد');
        }

        // Delete the physical file from the folder
        if (!empty($images->img_url)) {
            // Support both full URL paths and relative paths stored in DB
            $relativePath = ltrim(parse_url($images->img_url, PHP_URL_PATH), '/');

            // Try public disk path first
            $publicPath = public_path($relativePath);
            if (file_exists($publicPath)) {
                @unlink($publicPath);
            } elseif (Storage::exists($relativePath)) {
                Storage::delete($relativePath);
            }
        }

        $images->delete();

        return $this->sendSuccess('Image deleted successfully');
    }
}
