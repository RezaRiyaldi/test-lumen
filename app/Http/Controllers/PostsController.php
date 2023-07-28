<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
   public function index()
   {
      $posts = Post::all();

      return response()->json([
         'success' => true,
         'message' => 'List Posts',
         'data' => $posts
      ], 200);
   }

   public function detail($id) {
      $post = Post::find($id);

      if ($post) {
         return response()->json([
            'success' => true,
            'message' => 'Detail Post',
            'data' => $post
         ], 200);
      } else {
         return response()->json([
            'success' => false,
            'message' => 'Post tidak ditemukan!'
         ], 404);
      }
   }

   public function store(Request $request) {
      $validator = Validator::make($request->all(), [
         'title' => 'required',
         'content' => 'required',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'success' => false,
            'message' => 'Terdapat error',
            'data' => $validator->errors()
         ], 401);
      } else {
         $post = Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
         ]);

         if ($post) {
            return response()->json([
               'success' => true,
               'message' => 'Berhasil menyimpan Post!',
               'data' => $post
            ], 201);
         } else {
            return response()->json([
               'success' => false,
               'message' => 'Gagal menyimpan Post!',
            ], 400);

         }
      }
   }
}
