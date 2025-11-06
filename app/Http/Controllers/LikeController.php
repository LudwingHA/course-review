<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Alternar like entre on/off
     */
    public function toggle($type, $id)
    {
        $user = auth()->user();

        // Determinar modelo según tipo
        $model = match ($type) {
            'course' => Course::findOrFail($id),
            'review' => Review::findOrFail($id),
            default => abort(404),
        };

        // Buscar si ya existe el like
        $existingLike = $model->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete(); // Quitar like
        } else {
            $model->likes()->create(['user_id' => $user->id]); // Dar like
        }

        // Redirigir de vuelta
        return back()->with('success', 'Acción realizada correctamente.');
    }
}
