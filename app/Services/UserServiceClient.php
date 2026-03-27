<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserServiceClient
{
    private string $baseUrl;
    private string $apiKey;
    private int    $timeout;

    public function __construct()
    {
        $this->baseUrl = config('services.user_service.url', '');
        $this->apiKey  = config('services.user_service.api_key', '');
        $this->timeout = (int) config('services.user_service.timeout', 5);
    }

    public function isConfigured(): bool
    {
        return ! empty($this->baseUrl) && ! empty($this->apiKey);
    }

    // ── Auth ─────────────────────────────────────────────────

    /**
     * Step 1 — Validate credentials, get pre-auth token
     */
    public function login(string $identifier, string $password): ?array
    {
        $response = $this->post('/auth/login', [
            'identifier' => $identifier,
            'password'   => $password,
            'system'     => 'flowdesk',
        ]);

        return $response;
    }

    /**
     * Step 2 — Exchange pre-auth token for full JWT
     * Called after FlowDesk's own OTP verification
     */
    public function exchangeToken(string $preAuthToken): ?array
    {
        return $this->post('/auth/token', [
            'pre_auth_token' => $preAuthToken,
        ]);
    }

    /**
     * Refresh an expired access token
     */
    public function refreshToken(string $refreshToken): ?array
    {
        return $this->post('/auth/refresh', [
            'refresh_token' => $refreshToken,
        ]);
    }

    /**
     * Blacklist a token on logout
     */
    public function logout(string $accessToken): void
    {
        $this->postWithBearer('/auth/logout', [], $accessToken);
    }

    /**
     * Get the RSA public key for local JWT verification
     */
    public function getPublicKey(): ?string
    {
        $response = $this->get('/auth/public-key');
        return $response['public_key'] ?? null;
    }

    // ── Users ─────────────────────────────────────────────────

    /**
     * Create a user in User Service
     * Returns ['user' => [...], 'created' => bool]
     */
    public function createUser(array $data): ?array
    {
        return $this->post('/users', $data);
    }

    /**
     * Update a user in User Service
     */
    public function updateUser(string $userServiceId, array $data): ?array
    {
        return $this->put("/users/{$userServiceId}", $data);
    }

    /**
     * Get user by User Service UUID
     */
    public function getUser(string $userServiceId): ?array
    {
        return $this->get("/users/{$userServiceId}");
    }

    /**
     * Get user by PF number
     */
    public function getUserByPF(string $pfNumber): ?array
    {
        return $this->get("/users/pf/{$pfNumber}");
    }

    /**
     * Get all users updated since a given datetime (delta sync)
     */
    public function getDelta(\DateTimeInterface $since): ?array
    {
        return $this->get('/users/delta', [
            'since' => $since->format(\DateTimeInterface::RFC3339),
        ]);
    }

    /**
     * Get all users (full sync — paginated)
     */
    public function listUsers(int $limit = 100, int $offset = 0): ?array
    {
        return $this->get('/users', compact('limit', 'offset'));
    }

    /**
     * Deactivate user globally (all systems)
     */
    public function deactivateUser(string $userServiceId, string $reason = ''): ?array
    {
        return $this->post("/users/{$userServiceId}/deactivate", [
            'systems' => [], // empty = all systems
            'reason'  => $reason,
        ]);
    }

    /**
     * Deactivate user in specific systems only
     */
    public function deactivateUserInSystems(string $userServiceId, array $systems, string $reason = ''): ?array
    {
        return $this->post("/users/{$userServiceId}/deactivate", [
            'systems' => $systems,
            'reason'  => $reason,
        ]);
    }

    /**
     * Activate user
     */
    public function activateUser(string $userServiceId): ?array
    {
        return $this->post("/users/{$userServiceId}/activate", []);
    }

    // ── Health ────────────────────────────────────────────────

    public function isHealthy(): bool
    {
        try {
            $response = Http::timeout(2)->get($this->baseUrl . '/health');
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    // ── HTTP helpers ──────────────────────────────────────────

    private function get(string $path, array $query = []): ?array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders(['X-API-Key' => $this->apiKey])
                ->get($this->baseUrl . $path, $query);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("UserService GET {$path} failed: " . $response->status());
            return null;

        } catch (\Exception $e) {
            Log::error("UserService GET {$path} error: " . $e->getMessage());
            return null;
        }
    }

    private function post(string $path, array $data): ?array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders(['X-API-Key' => $this->apiKey])
                ->post($this->baseUrl . $path, $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("UserService POST {$path} failed: " . $response->status() .
                ' ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error("UserService POST {$path} error: " . $e->getMessage());
            return null;
        }
    }

    private function put(string $path, array $data): ?array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders(['X-API-Key' => $this->apiKey])
                ->put($this->baseUrl . $path, $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("UserService PUT {$path} failed: " . $response->status());
            return null;

        } catch (\Exception $e) {
            Log::error("UserService PUT {$path} error: " . $e->getMessage());
            return null;
        }
    }

    private function postWithBearer(string $path, array $data, string $token): ?array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'X-API-Key'     => $this->apiKey,
                    'Authorization' => "Bearer {$token}",
                ])
                ->post($this->baseUrl . $path, $data);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
