<?php

namespace App\Http\Controllers;

// use Google\Service\Dfareporting\Landingpage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Landingpage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $landingPages = Landingpage::all();
        return view('admin.landingPage.index', compact('landingPages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'tagline' => 'required|string',
            'title_short_definition' => 'required|string',
            'short_definition' => 'required|string',
            'title_of_data1' => 'required|string',
            'number_of_data1' => 'required|string',
            'tag_of_data1' => 'required|string',
            'title_of_data2' => 'required|string',
            'number_of_data2' => 'required|string',
            'tag_of_data2' => 'required|string',
            'title_of_data3' => 'required|string',
            'number_of_data3' => 'required|string',
            'tag_of_data3' => 'required|string',
            'title_corporate_profile' => 'required|string',
            'definition_corporate_profile' => 'required|string',
            'image_corporate_profile' => 'required|image|mimes:JPEG,JPG,PNG,jpeg,jpg,png,gif,svg,webp|max:2048',
            'key_feature_title1' => 'required|string',
            'key_feature_desc1' => 'required|string',
            'key_feature_image1' => 'required|image|mimes:JPEG,JPG,PNG,jpeg,jpg,png,gif,svg,webp|max:2048',
            'key_feature_title2' => 'required|string',
            'key_feature_desc2' => 'required|string',
            'key_feature_image2' => 'required|image|mimes:JPEG,JPG,PNG,jpeg,jpg,png,gif,svg,webp|max:2048',
            'key_feature_title3' => 'required|string',
            'key_feature_desc3' => 'required|string',
            'key_feature_image3' => 'required|image|mimes:JPEG,JPG,PNG,jpeg,jpg,png,gif,svg,webp|max:2048',
            'key_feature_title4' => 'required|string',
            'key_feature_desc4' => 'required|string',
            'key_feature_image4' => 'required|image|mimes:JPEG,JPG,PNG,jpeg,jpg,png,gif,svg,webp|max:2048',
        ]);

        // Handle image uploads and store paths
        $imageCorporateProfile = $request->file('image_corporate_profile')->store('img', 'public');
        $keyFeatureImage1 = $request->file('key_feature_image1')->store('img', 'public');
        $keyFeatureImage2 = $request->file('key_feature_image2')->store('img', 'public');
        $keyFeatureImage3 = $request->file('key_feature_image3')->store('img', 'public');
        $keyFeatureImage4 = $request->file('key_feature_image4')->store('img', 'public');

        // Create new landing page record with image paths
        Landingpage::create([
            'tagline' => $request->input('tagline'),
            'title_short_definition' => $request->input('title_short_definition'),
            'short_definition' => $request->input('short_definition'),
            'title_of_data1' => $request->input('title_of_data1'),
            'number_of_data1' => $request->input('number_of_data1'),
            'tag_of_data1' => $request->input('tag_of_data1'),
            'title_of_data2' => $request->input('title_of_data2'),
            'number_of_data2' => $request->input('number_of_data2'),
            'tag_of_data2' => $request->input('tag_of_data2'),
            'title_of_data3' => $request->input('title_of_data3'),
            'number_of_data3' => $request->input('number_of_data3'),
            'tag_of_data3' => $request->input('tag_of_data3'),
            'title_corporate_profile' => $request->input('title_corporate_profile'),
            'definition_corporate_profile' => $request->input('definition_corporate_profile'),
            'image_corporate_profile' => $imageCorporateProfile,
            'key_feature_title1' => $request->input('key_feature_title1'),
            'key_feature_desc1' => $request->input('key_feature_desc1'),
            'key_feature_image1' => $keyFeatureImage1,
            'key_feature_title2' => $request->input('key_feature_title2'),
            'key_feature_desc2' => $request->input('key_feature_desc2'),
            'key_feature_image2' => $keyFeatureImage2,
            'key_feature_title3' => $request->input('key_feature_title3'),
            'key_feature_desc3' => $request->input('key_feature_desc3'),
            'key_feature_image3' => $keyFeatureImage3,
            'key_feature_title4' => $request->input('key_feature_title4'),
            'key_feature_desc4' => $request->input('key_feature_desc4'),
            'key_feature_image4' => $keyFeatureImage4,
        ]);

        // Redirect with success message
        return redirect()->route('landing-page.index')->with('success', 'Landing page added successfully.');
    }


    protected function uploadImage($file, $prefix)
    {
        // Generate a unique filename
        $filename = $prefix . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        // Store the file in the 'img' directory on the public disk
        $file->storeAs('img', $filename, 'public');

        return $filename;
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'tagline' => 'required|string',
            'title_short_definition' => 'required|string',
            'short_definition' => 'required|string',
            'title_of_data1' => 'required|string',
            'number_of_data1' => 'required|string',
            'tag_of_data1' => 'required|string',
            'title_of_data2' => 'required|string',
            'number_of_data2' => 'required|string',
            'tag_of_data2' => 'required|string',
            'title_of_data3' => 'required|string',
            'number_of_data3' => 'required|string',
            'tag_of_data3' => 'required|string',
            'title_corporate_profile' => 'required|string',
            'definition_corporate_profile' => 'required|string',
            'image_corporate_profile' => 'nullable|image|mimes:JPEG,JPG,PNG,jpeg,png,jpg,gif,svg,webp|max:2048',
            'key_feature_title1' => 'required|string',
            'key_feature_desc1' => 'required|string',
            'key_feature_image1' => 'nullable|image|mimes:JPEG,JPG,PNG,jpeg,png,jpg,gif,svg,webp|max:2048',
            'key_feature_title2' => 'required|string',
            'key_feature_desc2' => 'required|string',
            'key_feature_image2' => 'nullable|image|mimes:JPEG,JPG,PNG,jpeg,png,jpg,gif,svg,webp|max:2048',
            'key_feature_title3' => 'required|string',
            'key_feature_desc3' => 'required|string',
            'key_feature_image3' => 'nullable|image|mimes:JPEG,JPG,PNG,jpeg,png,jpg,gif,svg,webp|max:2048',
            'key_feature_title4' => 'required|string',
            'key_feature_desc4' => 'required|string',
            'key_feature_image4' => 'nullable|image|mimes:JPEG,JPG,PNG,jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        // Find the existing landing page entry
        $landingPage = Landingpage::findOrFail($id);

        // Handle image uploads and store paths
        if ($request->hasFile('image_corporate_profile')) {
            // Delete old image if exists
            if ($landingPage->image_corporate_profile) {
                Storage::disk('public')->delete($landingPage->image_corporate_profile);
            }
            // Upload new image
            $landingPage->image_corporate_profile = $request->file('image_corporate_profile')->store('img', 'public');
        }

        if ($request->hasFile('key_feature_image1')) {
            if ($landingPage->key_feature_image1) {
                Storage::disk('public')->delete($landingPage->key_feature_image1);
            }
            $landingPage->key_feature_image1 = $request->file('key_feature_image1')->store('img', 'public');
        }

        if ($request->hasFile('key_feature_image2')) {
            if ($landingPage->key_feature_image2) {
                Storage::disk('public')->delete($landingPage->key_feature_image2);
            }
            $landingPage->key_feature_image2 = $request->file('key_feature_image2')->store('img', 'public');
        }

        if ($request->hasFile('key_feature_image3')) {
            if ($landingPage->key_feature_image3) {
                Storage::disk('public')->delete($landingPage->key_feature_image3);
            }
            $landingPage->key_feature_image3 = $request->file('key_feature_image3')->store('img', 'public');
        }

        if ($request->hasFile('key_feature_image4')) {
            if ($landingPage->key_feature_image4) {
                Storage::disk('public')->delete($landingPage->key_feature_image4);
            }
            $landingPage->key_feature_image4 = $request->file('key_feature_image4')->store('img', 'public');
        }

        // Update landing page data
        $landingPage->update([
            'tagline' => $request->input('tagline'),
            'title_short_definition' => $request->input('title_short_definition'),
            'short_definition' => $request->input('short_definition'),
            'title_of_data1' => $request->input('title_of_data1'),
            'number_of_data1' => $request->input('number_of_data1'),
            'tag_of_data1' => $request->input('tag_of_data1'),
            'title_of_data2' => $request->input('title_of_data2'),
            'number_of_data2' => $request->input('number_of_data2'),
            'tag_of_data2' => $request->input('tag_of_data2'),
            'title_of_data3' => $request->input('title_of_data3'),
            'number_of_data3' => $request->input('number_of_data3'),
            'tag_of_data3' => $request->input('tag_of_data3'),
            'title_corporate_profile' => $request->input('title_corporate_profile'),
            'definition_corporate_profile' => $request->input('definition_corporate_profile'),
            'key_feature_title1' => $request->input('key_feature_title1'),
            'key_feature_desc1' => $request->input('key_feature_desc1'),
            'key_feature_title2' => $request->input('key_feature_title2'),
            'key_feature_desc2' => $request->input('key_feature_desc2'),
            'key_feature_title3' => $request->input('key_feature_title3'),
            'key_feature_desc3' => $request->input('key_feature_desc3'),
            'key_feature_title4' => $request->input('key_feature_title4'),
            'key_feature_desc4' => $request->input('key_feature_desc4'),
        ]);

        // Redirect with success message
        return redirect()->route('landing-page.index')->with('success', 'Landing page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Landingpage $landingPage)
    {
        // Get the image path from the database
        $imagePath = 'img/' . $landingPage->image_corporate_profile;

        // Log the path for debugging
        Log::info('Attempting to delete image at: ' . $imagePath);

        // Check if the image exists in storage
        if ($landingPage->image_corporate_profile && Storage::exists($imagePath)) {
            // Attempt to delete the image file
            if (Storage::delete($imagePath)) {
                Log::info('Successfully deleted image: ' . $imagePath);
            } else {
                Log::error('Failed to delete image: ' . $imagePath);
            }
        } else {
            Log::warning('Image does not exist: ' . $imagePath);
        }

        // Delete the landing page record from the database
        $landingPage->delete();

        return redirect()->route('landing-page.index')->with('success', 'Landing page and associated image deleted successfully.');
    }
}