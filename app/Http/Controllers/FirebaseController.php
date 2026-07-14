<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FirebaseController extends Controller
{
    private $database;

    public function __construct()
    {
        $this->database = \App\Services\FirebaseService::connect();

        if (! $this->database) {
            \Log::warning('FirebaseController initialized without active Firebase database connection');
        }
    }

    public function read(Request $request): JsonResponse
    {
        $path = $request->query('path') ?? $request->input('path');

        if (! $path) {
            return response()->json(['success' => false, 'message' => 'path is required'], 400);
        }

        try {
            if (! $this->database) {
                return response()->json(['success' => false, 'message' => 'Firebase not connected'], 500);
            }

            $reference = $this->database->getReference($path);
            $snapshot = $reference->getSnapshot();
            $data = $snapshot->exists() ? $snapshot->getValue() : null;

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {
            \Log::error('FirebaseController::read error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function write(Request $request): JsonResponse
    {
        return response()->json(['success' => false, 'message' => 'Write operations are disabled in this Firebase read-only controller'], 403);
    }

    public function create(Request $request): JsonResponse
    {
        return response()->json(['success' => false, 'message' => 'Create operations are disabled in this Firebase read-only controller'], 403);
    }

    public function index(): JsonResponse
    {
        if (! $this->database) {
            return response()->json(['success' => false, 'message' => 'Firebase not connected'], 500);
        }

        $data = $this->database->getReference('test/blogs')->getValue();

        return response()->json(['success' => true, 'data' => $data]);
    }
}
