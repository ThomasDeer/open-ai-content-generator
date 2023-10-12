<?php

/**
 * OpenAI_API_Handler class.
 *
 * This class provides a simple interface to interact with the OpenAI API.
 * It allows users to generate content based on a given prompt.
 */
class OpenAI_API_Handler {

    /**
     * The API key used to authenticate with the OpenAI API.
     *
     * @var string
     */
    private $api_key;

    /**
     * Constructor.
     *
     * Initializes the OpenAI_API_Handler object with the provided API key.
     *
     * @param string $api_key The API key for the OpenAI API.
     */
    public function __construct($api_key) {
        $this->api_key = $api_key;
    }

    /**
     * Generate content based on a given prompt.
     *
     * This method sends a request to the OpenAI API with the provided prompt
     * and returns the generated content.
     *
     * @param string $prompt The prompt based on which the content should be generated.
     * @return string The generated content.
     */
    public function generate_content($prompt) {
        // Send a POST request to the OpenAI API.
        $response = wp_remote_post('https://api.openai.com/v1/engines/davinci/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'prompt' => $prompt,
                'max_tokens' => 150
            ])
        ]);

        // Retrieve the body of the response.
        $body = wp_remote_retrieve_body($response);

        // Decode the JSON response.
        $data = json_decode($body, true);

        // Return the generated content.
        return $data['choices'][0]['text'];
    }
}
