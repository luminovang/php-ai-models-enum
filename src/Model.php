<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 * @link https://luminova.ng
 */
namespace Luminova\AI;

/**
 * String-backed enum cataloguing every AI model identifier supported by
 * Luminova's built-in providers (OpenAI, Anthropic, Ollama).
 *
 * Each case name is a readable PHP identifier; its `->value` is the exact
 * string the provider API expects in the `model` field.
 *
 * **Getting the API string**
 * ```php
 * use Luminova\AI\Model;
 *
 * // Pass ->value wherever the provider expects a plain model string.
 * $ai->message('Hello!', ['model' => Model::GPT_4_1_MINI->value]);
 * $ai->message('Hello!', ['model' => Model::CLAUDE_SONNET_4_6->value]);
 * $ai->message('Hello!', ['model' => Model::LLAVA->value]);
 * ```
 *
 * **Resolving from an API string (built-in enum methods)**
 * ```php
 * // Throws \ValueError when the string is not a known case.
 * $model = Model::from('gpt-4.1-mini');
 *
 * // Returns null when the string is not known — safe for user input.
 * $model = Model::tryFrom($userInput) ?? Model::GPT_4_1_MINI;
 * ```
 *
 * **Iterating all cases**
 * ```php
 * foreach (Model::cases() as $model) {
 *     echo $model->name . ' => ' . $model->value . PHP_EOL;
 * }
 * ```
 *
 * **Instance helpers (called on a case)**
 * ```php
 * Model::O3->provider();      // 'openai'
 * Model::O3->isReasoning();   // true
 * Model::O3->isVision();      // true
 * Model::O3->capabilities();  // ['chat', 'vision', 'reasoning', 'coding']
 * ```
 *
 * **Static helpers (called on the enum)**
 * ```php
 * Model::forProvider('openai');          // [Model::GPT_5, Model::GPT_4_1_MINI, ...]
 * Model::forCapability('vision');        // [Model::GPT_4_1, Model::LLAVA, ...]
 * Model::resolve('gpt-4.1-mini');        // Model::GPT_4_1_MINI  (or null)
 * ```
 *
 * **Naming convention**
 * - Hyphens and dots → underscores: `gpt-4.1-mini` → `GPT_4_1_MINI`.
 * - Size-tag suffixes: `llama3.1:8b` → `LLAMA_3_1_8B`.
 * - Versioned snapshots have both a clean alias (`CLAUDE_OPUS_4_5`) and a
 *   pinned snapshot (`CLAUDE_OPUS_4_5_SNAP`) so you can choose between
 *   always-latest and guaranteed reproducibility.
 *
 * @see https://platform.openai.com/docs/models
 * @see https://docs.anthropic.com/en/docs/about-claude/models
 * @see https://ollama.com/library
 */
enum Model: string
{
    /** GPT-5 — OpenAI's flagship model. Complex reasoning, coding, multimodal. 256 K context. */
    case GPT_5 = 'gpt-5';

    /** GPT-5 Mini — faster, more affordable GPT-5 variant. Strong balance of capability and price. */
    case GPT_5_MINI = 'gpt-5-mini';

    /** GPT-5 Nano — smallest GPT-5 variant, optimised for latency and cost. */
    case GPT_5_NANO = 'gpt-5-nano';

    /**
     * GPT-4.1 — improved instruction-following, coding, and 1 M token context.
     * Supports fine-tuning.
     */
    case GPT_4_1 = 'gpt-4.1';

    /**
     * GPT-4.1 Mini — efficient mid-tier model; also supports fine-tuning.
     * Default chat model for the Luminova OpenAI provider.
     */
    case GPT_4_1_MINI = 'gpt-4.1-mini';

    /**
     * GPT-4.1 Nano — fastest, lowest-cost GPT-4.1 variant; supports fine-tuning.
     * Ideal for simple classification or extraction tasks.
     */
    case GPT_4_1_NANO = 'gpt-4.1-nano';

    /** GPT-4o — multimodal model; text + image input, audio I/O. 128 K context. */
    case GPT_4O = 'gpt-4o';

    /** GPT-4o Mini — lightweight, cost-effective GPT-4o variant. 128 K context. */
    case GPT_4O_MINI = 'gpt-4o-mini';

    /** GPT-4o Audio — native audio input and output. Best used with the Audio API. */
    case GPT_4O_AUDIO = 'gpt-4o-audio-preview';

    /** GPT-4o Mini Audio — lower-cost audio variant of GPT-4o Mini. */
    case GPT_4O_MINI_AUDIO = 'gpt-4o-mini-audio-preview';

    /** GPT-4o Realtime — optimised for low-latency real-time speech and text. */
    case GPT_4O_REALTIME = 'gpt-4o-realtime-preview';

    /** GPT-4o Mini Realtime — low-latency, lower-cost realtime variant. */
    case GPT_4O_MINI_REALTIME = 'gpt-4o-mini-realtime-preview';

    /** Computer Use Preview — model tuned to drive GUI interfaces via the Responses API. */
    case COMPUTER_USE = 'computer-use-preview';

    /**
     * o3 — most capable general-purpose reasoning model.
     * Excels at math, science, coding, and multi-step analysis. Supports visual reasoning.
     */
    case O3 = 'o3';

    /** o3 Pro — o3 with additional compute for maximum reasoning reliability. */
    case O3_PRO = 'o3-pro';

    /** o3 Deep Research — multi-step web and document research variant. */
    case O3_DEEP_RESEARCH = 'o3-deep-research';

    /**
     * o4 Mini — fast, cost-efficient reasoning model.
     * Top-performing on math, coding, and visual benchmarks.
     */
    case O4_MINI = 'o4-mini';

    /** o4 Mini Deep Research — deep research variant of o4 Mini. */
    case O4_MINI_DEEP_RESEARCH = 'o4-mini-deep-research';

    /**
     * GPT Image 1.5 — latest OpenAI image model. High-resolution + inpainting.
     * Requires access approval.
     */
    case GPT_IMAGE_1_5 = 'gpt-image-1.5';

    /**
     * GPT Image 1 — first-generation unified image model (generation, inpainting, editing).
     * Default image model in the Luminova OpenAI provider. Requires access approval.
     */
    case GPT_IMAGE_1 = 'gpt-image-1';

    /** DALL-E 3 — high-quality image generation, generally available. Up to 1792×1024 px. */
    case DALL_E_3 = 'dall-e-3';

    /** DALL-E 2 — previous-generation image model; more affordable, lower detail. */
    case DALL_E_2 = 'dall-e-2';

    /**
     * GPT-4o Mini TTS — expressive, controllable speech synthesis.
     * Default TTS model in the Luminova OpenAI provider.
     * Voices: `alloy`, `echo`, `fable`, `onyx`, `nova`, `shimmer`.
     */
    case GPT_4O_MINI_TTS = 'gpt-4o-mini-tts';

    /** TTS-1 — first-generation TTS; optimised for real-time use. Six preset voices. */
    case TTS_1 = 'tts-1';

    /** TTS-1 HD — higher-quality TTS; more natural intonation and smoothness. */
    case TTS_1_HD = 'tts-1-hd';

    /** GPT-4o Transcribe — superior accuracy with multilingual support; recommended for production. */
    case GPT_4O_TRANSCRIBE = 'gpt-4o-transcribe';

    /** GPT-4o Mini Transcribe — faster, lower-cost transcription; currently recommended over GPT-4o Transcribe. */
    case GPT_4O_MINI_TRANSCRIBE = 'gpt-4o-mini-transcribe';

    /**
     * Whisper-1 — general-purpose speech recognition across 99+ languages.
     * Default transcription model in the Luminova OpenAI provider.
     */
    case WHISPER_1 = 'whisper-1';

    /**
     * Text Embedding 3 Large — highest-accuracy embedding model.
     * 3072-dimensional output (reducible). Best for production RAG and semantic search.
     */
    case TEXT_EMBEDDING_3_LARGE = 'text-embedding-3-large';

    /**
     * Text Embedding 3 Small — efficient third-generation model. 1536-dimensional output.
     * Default embedding model in the Luminova OpenAI provider.
     */
    case TEXT_EMBEDDING_3_SMALL = 'text-embedding-3-small';

    /** Text Embedding Ada 002 — second-generation model (legacy). Prefer 3 Small for new work. */
    case TEXT_EMBEDDING_ADA_002 = 'text-embedding-ada-002';

    /** Omni Moderation Latest — multi-modal content moderation (text + image). */
    case OMNI_MODERATION = 'omni-moderation-latest';

    /** Text Moderation Latest — text-only content moderation. */
    case TEXT_MODERATION = 'text-moderation-latest';

    /**
     * Claude Opus 4.6 — most capable Anthropic model (Feb 2026).
     * Exceptional coding, reasoning; ~14.5 h task horizon (METR benchmark).
     * Supports 1 M token context with `context-1m-2025-08-07` beta header.
     */
    case CLAUDE_OPUS_4_6 = 'claude-opus-4-6';

    /**
     * Claude Sonnet 4.6 — latest Sonnet (Feb 2026); same price as Sonnet 4.5.
     * Preferred over previous Opus in coding evaluations by 59% of developers.
     * Default Claude model in the Luminova Anthropic provider.
     */
    case CLAUDE_SONNET_4_6 = 'claude-sonnet-4-6';

    /** Claude Opus 4.5 (Nov 2025) — 67% price cut; 76% fewer output tokens vs previous Opus. */
    case CLAUDE_OPUS_4_5 = 'claude-opus-4-5';

    /** Claude Opus 4.5 (pinned snapshot 2025-11-01) — guaranteed reproducibility. */
    case CLAUDE_OPUS_4_5_SNAP = 'claude-opus-4-5-20251101';

    /** Claude Sonnet 4.5 — industry-leading agent capabilities; strong coding and computer use. */
    case CLAUDE_SONNET_4_5 = 'claude-sonnet-4-5';

    /** Claude Haiku 4.5 — fastest, most cost-effective Claude 4.5 model (Oct 2025). */
    case CLAUDE_HAIKU_4_5 = 'claude-haiku-4-5';

    /** Claude Haiku 4.5 (pinned snapshot 2025-10-01). */
    case CLAUDE_HAIKU_4_5_SNAP = 'claude-haiku-4-5-20251001';

    /** Claude Opus 4.1 — industry leader for coding, agentic search, and long-horizon tasks. */
    case CLAUDE_OPUS_4_1 = 'claude-opus-4-1';

    /** Claude Opus 4.1 (pinned snapshot 2025-08-05). */
    case CLAUDE_OPUS_4_1_SNAP = 'claude-opus-4-1-20250805';

    /** Claude Sonnet 4.1 — production-ready agents at scale. */
    case CLAUDE_SONNET_4_1 = 'claude-sonnet-4-1';

    /** Claude Opus 4 — first Claude 4-gen Opus (May 2025). State-of-the-art coding at release. */
    case CLAUDE_OPUS_4 = 'claude-opus-4-0';

    /** Claude Sonnet 4 — first Claude 4-gen Sonnet; fast and context-aware. */
    case CLAUDE_SONNET_4 = 'claude-sonnet-4-0';

    /**
     * Claude Sonnet 3.7 — introduced extended (hybrid) thinking (Feb 2025).
     * Major capability jump for math, science, and multi-step code problems.
     */
    case CLAUDE_SONNET_3_7 = 'claude-sonnet-3-7';

    /** Claude Sonnet 3.7 (pinned snapshot 2025-02-19). */
    case CLAUDE_SONNET_3_7_SNAP = 'claude-3-7-sonnet-20250219';

    /** Claude Sonnet 3.5 v2 — upgraded Sonnet with computer use capability (Oct 2024). */
    case CLAUDE_SONNET_3_5 = 'claude-3-5-sonnet-20241022';

    /** Claude Haiku 3.5 — lightweight, fast Claude 3.5 variant. Ideal for rapid completions. */
    case CLAUDE_HAIKU_3_5 = 'claude-3-5-haiku-20241022';

    /** Llama 3 (8 B) — Meta's baseline Llama 3 chat model; most widely deployed locally. */
    case LLAMA_3 = 'llama3';

    /** Llama 3.1 — improved Llama 3 with 128 K context support. */
    case LLAMA_3_1 = 'llama3.1';

    /** Llama 3.1 (8 B explicit tag). */
    case LLAMA_3_1_8B = 'llama3.1:8b';

    /** Llama 3.1 (70 B) — large-scale variant; requires multi-GPU or high-VRAM hardware. */
    case LLAMA_3_1_70B = 'llama3.1:70b';

    /** Llama 3.2 — compact Meta model (1 B / 3 B); optimised for edge hardware. */
    case LLAMA_3_2 = 'llama3.2';

    /** Llama 3.2 (1 B) — ultra-compact for edge and embedded use. */
    case LLAMA_3_2_1B = 'llama3.2:1b';

    /** Llama 3.2 (3 B) — small but capable for CLI copilots and edge agents. */
    case LLAMA_3_2_3B = 'llama3.2:3b';

    /** Llama 3.3 (70 B) — latest large Llama model; excellent for long-form and complex chat. */
    case LLAMA_3_3 = 'llama3.3';

    /** Llama 3.3 (70 B explicit tag). */
    case LLAMA_3_3_70B = 'llama3.3:70b';

    /**
     * Gemma 3 — Google's current-generation open model (1 B–27 B).
     * 27 B outperforms models twice its size; 128 K context (4 B+). Vision-capable (4 B+).
     */
    case GEMMA_3 = 'gemma3';

    /** Gemma 3 (4 B) — efficient vision-capable variant; fits 8 GB VRAM. */
    case GEMMA_3_4B = 'gemma3:4b';

    /** Gemma 3 (12 B) — strong performance for 12–16 GB VRAM. */
    case GEMMA_3_12B = 'gemma3:12b';

    /** Gemma 3 (27 B) — flagship Gemma 3 variant. */
    case GEMMA_3_27B = 'gemma3:27b';

    /** Gemma 2 — previous Google Gemma generation; proven reliability (2 B, 9 B, 27 B). */
    case GEMMA_2 = 'gemma2';

    /** Gemma 2 (2 B) — smallest Gemma 2; suitable for edge deployments. */
    case GEMMA_2_2B = 'gemma2:2b';

    /** Gemma 2 (9 B) — good general-purpose performance within 10 GB VRAM. */
    case GEMMA_2_9B = 'gemma2:9b';

    /** Gemma 2 (27 B) — large-scale Gemma 2; creative and NLP-focused tasks. */
    case GEMMA_2_27B = 'gemma2:27b';

    /** Mistral 7B v0.3 — fast, efficient 7 B model with strong European language support. */
    case MISTRAL = 'mistral';

    /** Mistral (7 B explicit tag). */
    case MISTRAL_7B = 'mistral:7b';

    /** Mixtral 8×7B — Mixture-of-Experts from Mistral AI; 2 experts active per token. */
    case MIXTRAL_8X7B = 'mixtral:8x7b';

    /** Mixtral 8×22B — larger MoE variant; near-frontier quality for local hardware. */
    case MIXTRAL_8X22B = 'mixtral:8x22b';

    /**
     * Qwen 3 — latest Qwen generation; dense and MoE variants.
     * Up to 256 K token context; strong multilingual support.
     */
    case QWEN_3 = 'qwen3';

    /** Qwen 3 (4 B) — compact variant fitting low-VRAM hardware. */
    case QWEN_3_4B = 'qwen3:4b';

    /**
     * Qwen 3 (8 B tag) — compact variant fitting low-VRAM hardware.
     */
    case QWEN_3_8B = 'qwen3:8b';

    /** Qwen 3 (14 B) — solid mid-range capability for a single consumer GPU. */
    case QWEN_3_14B = 'qwen3:14b';

    /** Qwen 3 (72 B) — maximum Qwen 3 capability; enterprise-grade output. */
    case QWEN_3_72B = 'qwen3:72b';

    /** Qwen 2.5 — previous-generation; trained on 18 T tokens; 128 K context. */
    case QWEN_2_5 = 'qwen2.5';

    /** Qwen 2.5 (7 B). */
    case QWEN_2_5_7B = 'qwen2.5:7b';

    /** Qwen 2.5 (14 B). */
    case QWEN_2_5_14B = 'qwen2.5:14b';

    /**
     * Qwen 2.5 Coder — coding-focused variant; matches GPT-4o on code repair at 32 B.
     * Knows 87 programming languages.
     */
    case QWEN_2_5_CODER = 'qwen2.5-coder';

    /** Qwen 2.5 Coder (7 B) — excellent code quality for limited hardware. */
    case QWEN_2_5_CODER_7B = 'qwen2.5-coder:7b';

    /** Qwen 2.5 Coder (32 B) — best local coding model at this scale. */
    case QWEN_2_5_CODER_32B = 'qwen2.5-coder:32b';

    /**
     * DeepSeek R1 — open reasoning model family; matches o3 and Gemini 2.5 Pro
     * on key benchmarks.
     */
    case DEEPSEEK_R1 = 'deepseek-r1';

    /** DeepSeek R1 (7 B) — smallest R1; usable on 8–10 GB VRAM. */
    case DEEPSEEK_R1_7B = 'deepseek-r1:7b';

    /** DeepSeek R1 (14 B) — best mid-range reasoning for home labs. */
    case DEEPSEEK_R1_14B = 'deepseek-r1:14b';

    /** DeepSeek R1 (32 B) — stronger reasoning for 24 GB+ VRAM setups. */
    case DEEPSEEK_R1_32B = 'deepseek-r1:32b';

    /** DeepSeek R1 (70 B) — near-frontier reasoning; multi-GPU recommended. */
    case DEEPSEEK_R1_70B = 'deepseek-r1:70b';

    /**
     * DeepSeek Coder — code generation model; 87 programming languages.
     * Trained on 2 T tokens; handles cross-file code changes.
     */
    case DEEPSEEK_CODER = 'deepseek-coder';

    /** DeepSeek Coder (33 B) — top-quality local code generation. */
    case DEEPSEEK_CODER_33B = 'deepseek-coder:33b';

    /**
     * Phi-4 — Microsoft's latest lightweight model with strong reasoning.
     * 14 B parameters, 128 K context; excellent performance per parameter.
     */
    case PHI_4 = 'phi4';

    /** Phi-4 (14 B explicit tag). */
    case PHI_4_14B = 'phi4:14b';

    /**
     * Phi-3 — previous-generation Microsoft lightweight model (3.8 B Mini / 14 B Medium).
     * Phi-3 Mini runs on phones; Phi-3.5 extends context to 128 K.
     */
    case PHI_3 = 'phi3';

    /** Phi-3 Mini (3.8 B) — ultra-compact; suitable for on-device and IoT deployments. */
    case PHI_3_MINI = 'phi3:mini';

    /**
     * Code Llama — Meta's code-focused Llama model (7 B–70 B).
     * Strong across many languages; fill-in-the-middle support.
     */
    case CODE_LLAMA = 'codellama';

    /** Code Llama (13 B) — good balance of code quality and hardware requirement. */
    case CODE_LLAMA_13B = 'codellama:13b';

    /** Code Llama (34 B) — high-quality generation for 24 GB VRAM setups. */
    case CODE_LLAMA_34B = 'codellama:34b';

    /**
     * LLaVA — canonical first-choice multimodal vision-language model for Ollama.
     * Default vision model in the Luminova Ollama provider (`vision()`).
     */
    case LLAVA = 'llava';

    /** LLaVA (13 B) — stronger vision understanding at 13 B parameters. */
    case LLAVA_13B = 'llava:13b';

    /** LLaVA (34 B) — highest-quality LLaVA variant; requires 24+ GB VRAM. */
    case LLAVA_34B = 'llava:34b';

    /**
     * Llama 3.2 Vision — Meta's multimodal Llama 3.2.
     * Better structured-output and instruction-following than LLaVA.
     */
    case LLAMA_3_2_VISION = 'llama3.2-vision';

    /**
     * Moondream — tiny (1.8 B) vision-language model designed for edge devices.
     * Very fast image captioning and Q&A.
     */
    case MOONDREAM = 'moondream';

    /**
     * BakLLaVA — Mistral-7B base with LLaVA multimodal fine-tuning.
     * Strong language generation quality alongside vision understanding.
     */
    case BAKLLAVA = 'bakllava';

    /**
     * Nomic Embed Text — high-performing open embedding model.
     * 8 K token context; strong MTEB benchmark scores.
     * Default embedding model in the Luminova Ollama provider.
     */
    case NOMIC_EMBED_TEXT = 'nomic-embed-text';

    /**
     * Mxbai Embed Large — 1024-dimensional open embedding model.
     * Competitive with text-embedding-3-large on several benchmarks.
     */
    case MXBAI_EMBED_LARGE = 'mxbai-embed-large';

    /**
     * All-MiniLM — lightweight sentence embedding model (384-dimensional).
     * Very fast; ideal for real-time similarity search.
     */
    case ALL_MINILM = 'all-minilm';

    /**
     * Maps every case value to its provider short-name.
     * Provider keys match those registered in `AI::$providers`.
     *
     * @var array<string,string>
     */
    private const PROVIDER_MAP = [
        // — OpenAI —
        'gpt-5'                        => 'openai',
        'gpt-5-mini'                   => 'openai',
        'gpt-5-nano'                   => 'openai',
        'gpt-4.1'                      => 'openai',
        'gpt-4.1-mini'                 => 'openai',
        'gpt-4.1-nano'                 => 'openai',
        'gpt-4o'                       => 'openai',
        'gpt-4o-mini'                  => 'openai',
        'gpt-4o-audio-preview'         => 'openai',
        'gpt-4o-mini-audio-preview'    => 'openai',
        'gpt-4o-realtime-preview'      => 'openai',
        'gpt-4o-mini-realtime-preview' => 'openai',
        'computer-use-preview'         => 'openai',
        'o3'                           => 'openai',
        'o3-pro'                       => 'openai',
        'o3-deep-research'             => 'openai',
        'o4-mini'                      => 'openai',
        'o4-mini-deep-research'        => 'openai',
        'gpt-image-1.5'                => 'openai',
        'gpt-image-1'                  => 'openai',
        'dall-e-3'                     => 'openai',
        'dall-e-2'                     => 'openai',
        'gpt-4o-mini-tts'              => 'openai',
        'tts-1'                        => 'openai',
        'tts-1-hd'                     => 'openai',
        'gpt-4o-transcribe'            => 'openai',
        'gpt-4o-mini-transcribe'       => 'openai',
        'whisper-1'                    => 'openai',
        'text-embedding-3-large'       => 'openai',
        'text-embedding-3-small'       => 'openai',
        'text-embedding-ada-002'       => 'openai',
        'omni-moderation-latest'       => 'openai',
        'text-moderation-latest'       => 'openai',
        // — Anthropic / Claude —
        'claude-opus-4-6'              => 'anthropic',
        'claude-sonnet-4-6'            => 'anthropic',
        'claude-opus-4-5'              => 'anthropic',
        'claude-opus-4-5-20251101'     => 'anthropic',
        'claude-sonnet-4-5'            => 'anthropic',
        'claude-haiku-4-5'             => 'anthropic',
        'claude-haiku-4-5-20251001'    => 'anthropic',
        'claude-opus-4-1'              => 'anthropic',
        'claude-opus-4-1-20250805'     => 'anthropic',
        'claude-sonnet-4-1'            => 'anthropic',
        'claude-opus-4-0'              => 'anthropic',
        'claude-sonnet-4-0'            => 'anthropic',
        'claude-sonnet-3-7'            => 'anthropic',
        'claude-3-7-sonnet-20250219'   => 'anthropic',
        'claude-3-5-sonnet-20241022'   => 'anthropic',
        'claude-3-5-haiku-20241022'    => 'anthropic',
        // — Ollama —
        'llama3'                       => 'ollama',
        'llama3.1'                     => 'ollama',
        'llama3.1:8b'                  => 'ollama',
        'llama3.1:70b'                 => 'ollama',
        'llama3.2'                     => 'ollama',
        'llama3.2:1b'                  => 'ollama',
        'llama3.2:3b'                  => 'ollama',
        'llama3.3'                     => 'ollama',
        'llama3.3:70b'                 => 'ollama',
        'gemma3'                       => 'ollama',
        'gemma3:4b'                    => 'ollama',
        'gemma3:12b'                   => 'ollama',
        'gemma3:27b'                   => 'ollama',
        'gemma2'                       => 'ollama',
        'gemma2:2b'                    => 'ollama',
        'gemma2:9b'                    => 'ollama',
        'gemma2:27b'                   => 'ollama',
        'mistral'                      => 'ollama',
        'mistral:7b'                   => 'ollama',
        'mixtral:8x7b'                 => 'ollama',
        'mixtral:8x22b'                => 'ollama',
        'qwen3'                        => 'ollama',
        'qwen3:4b'                     => 'ollama',
        'qwen3:8b'                     => 'ollama',
        'qwen3:14b'                    => 'ollama',
        'qwen3:72b'                    => 'ollama',
        'qwen2.5'                      => 'ollama',
        'qwen2.5:7b'                   => 'ollama',
        'qwen2.5:14b'                  => 'ollama',
        'qwen2.5-coder'                => 'ollama',
        'qwen2.5-coder:7b'             => 'ollama',
        'qwen2.5-coder:32b'            => 'ollama',
        'deepseek-r1'                  => 'ollama',
        'deepseek-r1:7b'               => 'ollama',
        'deepseek-r1:14b'              => 'ollama',
        'deepseek-r1:32b'              => 'ollama',
        'deepseek-r1:70b'              => 'ollama',
        'deepseek-coder'               => 'ollama',
        'deepseek-coder:33b'           => 'ollama',
        'phi4'                         => 'ollama',
        'phi4:14b'                     => 'ollama',
        'phi3'                         => 'ollama',
        'phi3:mini'                    => 'ollama',
        'codellama'                    => 'ollama',
        'codellama:13b'                => 'ollama',
        'codellama:34b'                => 'ollama',
        'llava'                        => 'ollama',
        'llava:13b'                    => 'ollama',
        'llava:34b'                    => 'ollama',
        'llama3.2-vision'              => 'ollama',
        'moondream'                    => 'ollama',
        'bakllava'                     => 'ollama',
        'nomic-embed-text'             => 'ollama',
        'mxbai-embed-large'            => 'ollama',
        'all-minilm'                   => 'ollama',
    ];

    /**
     * Maps capability tags to the model values that support them.
     * A model may appear under multiple tags.
     *
     * @var array<string,string[]>
     */
    private const CAPABILITY_MAP = [
        'chat' => [
            'gpt-5', 'gpt-5-mini', 'gpt-5-nano',
            'gpt-4.1', 'gpt-4.1-mini', 'gpt-4.1-nano',
            'gpt-4o', 'gpt-4o-mini', 'gpt-4o-audio-preview', 'gpt-4o-mini-audio-preview',
            'gpt-4o-realtime-preview', 'gpt-4o-mini-realtime-preview',
            'o3', 'o3-pro', 'o3-deep-research', 'o4-mini', 'o4-mini-deep-research',
            'claude-opus-4-6', 'claude-sonnet-4-6',
            'claude-opus-4-5', 'claude-opus-4-5-20251101',
            'claude-sonnet-4-5', 'claude-haiku-4-5', 'claude-haiku-4-5-20251001',
            'claude-opus-4-1', 'claude-opus-4-1-20250805', 'claude-sonnet-4-1',
            'claude-opus-4-0', 'claude-sonnet-4-0',
            'claude-sonnet-3-7', 'claude-3-7-sonnet-20250219',
            'claude-3-5-sonnet-20241022', 'claude-3-5-haiku-20241022',
            'llama3', 'llama3.1', 'llama3.1:8b', 'llama3.1:70b',
            'llama3.2', 'llama3.2:1b', 'llama3.2:3b', 'llama3.3', 'llama3.3:70b',
            'gemma3', 'gemma3:4b', 'gemma3:12b', 'gemma3:27b',
            'gemma2', 'gemma2:2b', 'gemma2:9b', 'gemma2:27b',
            'mistral', 'mistral:7b', 'mixtral:8x7b', 'mixtral:8x22b',
            'qwen3', 'qwen3:4b', 'qwen3:8b', 'qwen3:14b', 'qwen3:72b',
            'qwen2.5', 'qwen2.5:7b', 'qwen2.5:14b',
            'deepseek-r1', 'deepseek-r1:7b', 'deepseek-r1:14b', 'deepseek-r1:32b', 'deepseek-r1:70b',
            'phi4', 'phi4:14b', 'phi3', 'phi3:mini',
            'codellama', 'codellama:13b', 'codellama:34b',
            'deepseek-coder', 'deepseek-coder:33b',
            'qwen2.5-coder', 'qwen2.5-coder:7b', 'qwen2.5-coder:32b',
        ],
        'vision' => [
            'gpt-5', 'gpt-5-mini', 'gpt-5-nano',
            'gpt-4.1', 'gpt-4.1-mini', 'gpt-4.1-nano',
            'gpt-4o', 'gpt-4o-mini',
            'o3', 'o3-pro', 'o4-mini',
            'claude-opus-4-6', 'claude-sonnet-4-6',
            'claude-opus-4-5', 'claude-opus-4-5-20251101',
            'claude-sonnet-4-5', 'claude-haiku-4-5', 'claude-haiku-4-5-20251001',
            'claude-opus-4-1', 'claude-opus-4-1-20250805', 'claude-sonnet-4-1',
            'claude-opus-4-0', 'claude-sonnet-4-0',
            'claude-sonnet-3-7', 'claude-3-7-sonnet-20250219',
            'claude-3-5-sonnet-20241022', 'claude-3-5-haiku-20241022',
            'llava', 'llava:13b', 'llava:34b',
            'llama3.2-vision',
            'moondream',
            'bakllava',
            'gemma3:4b', 'gemma3:12b', 'gemma3:27b',
        ],
        'image' => [
            'gpt-image-1.5', 'gpt-image-1', 'dall-e-3', 'dall-e-2',
        ],
        'embedding' => [
            'text-embedding-3-large', 'text-embedding-3-small', 'text-embedding-ada-002',
            'nomic-embed-text', 'mxbai-embed-large', 'all-minilm',
        ],
        'speech' => [
            'gpt-4o-mini-tts', 'tts-1', 'tts-1-hd',
        ],
        'transcription' => [
            'gpt-4o-transcribe', 'gpt-4o-mini-transcribe', 'whisper-1',
        ],
        'reasoning' => [
            'o3', 'o3-pro', 'o3-deep-research', 'o4-mini', 'o4-mini-deep-research',
            'deepseek-r1', 'deepseek-r1:7b', 'deepseek-r1:14b', 'deepseek-r1:32b', 'deepseek-r1:70b',
            'claude-sonnet-3-7', 'claude-3-7-sonnet-20250219',
        ],
        'coding' => [
            'gpt-4.1', 'gpt-4.1-mini', 'gpt-4.1-nano',
            'o3', 'o4-mini', 
            'claude-opus-4-6', 'claude-sonnet-4-6',
            'claude-opus-4-1', 'claude-opus-4-1-20250805',
            'codellama', 'codellama:13b', 'codellama:34b',
            'deepseek-coder', 'deepseek-coder:33b',
            'qwen2.5-coder', 'qwen3:8b', 'qwen2.5-coder:7b', 'qwen2.5-coder:32b',
        ],
        'fine-tuning' => [
            'gpt-4.1', 'gpt-4.1-mini', 'gpt-4.1-nano',
        ],
        'moderation' => [
            'omni-moderation-latest', 'text-moderation-latest',
        ],
    ];

    /**
     * Return the provider short-name for this model.
     *
     * Matches the key registered in `AI::$providers`:
     * `'openai'`, `'anthropic'`, or `'ollama'`.
     *
     * @return string
     *
     * @example
     * ```php
     * Model::GPT_4_1_MINI->provider();      // 'openai'
     * Model::CLAUDE_SONNET_4_6->provider(); // 'anthropic'
     * Model::LLAVA->provider();             // 'ollama'
     * ```
     */
    public function provider(): string
    {
        return self::PROVIDER_MAP[$this->value];
    }

    /**
     * Return all capability tags this model supports.
     *
     * Possible tags: `chat`, `vision`, `image`, `embedding`, `speech`,
     * `transcription`, `reasoning`, `coding`, `fine-tuning`, `moderation`.
     *
     * @return string[]
     *
     * @example
     * ```php
     * Model::O3->capabilities();
     * // ['chat', 'vision', 'reasoning', 'coding']
     *
     * Model::NOMIC_EMBED_TEXT->capabilities();
     * // ['embedding']
     *
     * Model::DALL_E_3->capabilities();
     * // ['image']
     * ```
     */
    public function capabilities(): array
    {
        $tags = [];

        foreach (self::CAPABILITY_MAP as $tag => $models) {
            if (in_array($this->value, $models, true)) {
                $tags[] = $tag;
            }
        }

        return $tags;
    }

    /**
     * Whether this model accepts image input (vision).
     *
     * @return bool
     *
     * @example
     * ```php
     * Model::GPT_4_1->isVision();          // true
     * Model::LLAVA->isVision();            // true
     * Model::NOMIC_EMBED_TEXT->isVision(); // false
     * ```
     */
    public function isVision(): bool
    {
        return in_array($this->value, self::CAPABILITY_MAP['vision'], true);
    }

    /**
     * Whether this is a reasoning / chain-of-thought model.
     *
     * @return bool
     *
     * @example
     * ```php
     * Model::O3->isReasoning();           // true
     * Model::DEEPSEEK_R1->isReasoning();  // true
     * Model::GPT_4_1_MINI->isReasoning(); // false
     * ```
     */
    public function isReasoning(): bool
    {
        return in_array($this->value, self::CAPABILITY_MAP['reasoning'], true);
    }

    /**
     * Whether this model produces vector embeddings.
     *
     * @return bool
     *
     * @example
     * ```php
     * Model::TEXT_EMBEDDING_3_SMALL->isEmbedding(); // true
     * Model::NOMIC_EMBED_TEXT->isEmbedding();       // true
     * Model::GPT_4_1->isEmbedding();                // false
     * ```
     */
    public function isEmbedding(): bool
    {
        return in_array($this->value, self::CAPABILITY_MAP['embedding'], true);
    }

    /**
     * Whether this model supports chat / completion.
     *
     * @return bool
     *
     * @example
     * ```php
     * Model::GPT_4_1_MINI->isChat(); // true
     * Model::DALL_E_3->isChat();     // false
     * ```
     */
    public function isChat(): bool
    {
        return in_array($this->value, self::CAPABILITY_MAP['chat'], true);
    }

    /**
     * Whether this model is optimised for code generation or completion.
     *
     * @return bool
     *
     * @example
     * ```php
     * Model::DEEPSEEK_CODER->isCoding(); // true
     * Model::LLAVA->isCoding();          // false
     * ```
     */
    public function isCoding(): bool
    {
        return in_array($this->value, self::CAPABILITY_MAP['coding'], true);
    }

    /**
     * Whether this model supports fine-tuning via the provider API.
     *
     * @return bool
     *
     * @example
     * ```php
     * Model::GPT_4_1_MINI->isFineTunable(); // true
     * Model::O3->isFineTunable();           // false
     * ```
     */
    public function isFineTunable(): bool
    {
        return in_array($this->value, self::CAPABILITY_MAP['fine-tuning'], true);
    }

    /**
     * Return all cases that belong to a specific provider.
     *
     * @param string $provider Provider short-name: `'openai'`, `'anthropic'`, or `'ollama'`.
     *
     * @return self[]
     *
     * @example
     * ```php
     * $cases = Model::forProvider('openai');
     * // [Model::GPT_5, Model::GPT_4_1_MINI, Model::O3, ...]
     *
     * foreach (Model::forProvider('ollama') as $model) {
     *     echo $model->name . ' = ' . $model->value . PHP_EOL;
     * }
     * ```
     */
    public static function forProvider(string $provider): array
    {
        $provider = strtolower($provider);

        return array_values(array_filter(
            self::cases(),
            fn(self $case): bool => (self::PROVIDER_MAP[$case->value] ?? null) === $provider
        ));
    }

    /**
     * Return all cases that support a given capability tag.
     *
     * Available tags: `chat`, `vision`, `image`, `embedding`, `speech`,
     * `transcription`, `reasoning`, `coding`, `fine-tuning`, `moderation`.
     *
     * @param string $capability Capability tag.
     *
     * @return self[]
     *
     * @example
     * ```php
     * $visionModels = Model::forCapability('vision');
     * // [Model::GPT_4_1, Model::GPT_4O, Model::LLAVA, Model::LLAMA_3_2_VISION, ...]
     *
     * $embeddingModels = Model::forCapability('embedding');
     * // [Model::TEXT_EMBEDDING_3_SMALL, Model::NOMIC_EMBED_TEXT, ...]
     * ```
     */
    public static function forCapability(string $capability): array
    {
        $modelValues = self::CAPABILITY_MAP[$capability] ?? [];

        return array_values(array_filter(
            self::cases(),
            fn(self $case): bool => in_array($case->value, $modelValues, true)
        ));
    }

    /**
     * Safely resolve a case from a raw API model string.
     *
     * Alias for the built-in `Model::tryFrom()` for clearer call-site intent.
     * Returns `null` when the string does not match any catalogued case —
     * use it to validate user-supplied or config-sourced model strings.
     *
     * @param string $modelId Exact API model string (e.g. `'gpt-4.1-mini'`).
     *
     * @return self|null Matching case, or `null` when not found.
     *
     * @example
     * ```php
     * $model = Model::resolve('gpt-4.1-mini'); // Model::GPT_4_1_MINI
     * $model = Model::resolve('unknown');       // null
     *
     * // Validate a user-supplied model string, fall back to a safe default:
     * $model = Model::resolve($userInput) ?? Model::GPT_4_1_MINI;
     *
     * // Use in a match with a resolved case:
     * $model = Model::resolve($config['model']) ?? Model::CLAUDE_SONNET_4_6;
     * $endpoint = match($model->provider()) {
     *     'openai'    => $openaiClient,
     *     'anthropic' => $claudeClient,
     *     'ollama'    => $ollamaClient,
     * };
     * ```
     */
    public static function resolve(string $modelId): ?self
    {
        return self::tryFrom($modelId);
    }
}
