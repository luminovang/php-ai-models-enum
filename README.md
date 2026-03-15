# PHP AI Model (Enum) Class

> **Type:** `enum Model: string` *(string-backed)* 

A string-backed enum cataloguing AI model identifiers. Each case name is a readable PHP identifier; its `->value` is the exact API string the client expects.

The enum version extends the [class version](https://github.com/luminovang/php-ai-models) with native PHP enum capabilities: exhaustive `match` checking, built-in `from()` / `tryFrom()` / `cases()`, type-safe function signatures, and instance methods that let you interrogate any case directly.

## Installation

Install via composer.

```php
composer install luminovang/php-ai-models-enum
```

> No additional dependencies beyond PHP 8.1.

[`Luminova\AI\Model` (const version)](https://github.com/luminovang/php-ai-models) — PHP constant final class.


---

## Table of Contents

- [Why an Enum?](#why-an-enum)
- [Installation / Import](#installation--import)
- [Naming Convention](#naming-convention)
- [Getting the API String](#getting-the-api-string)
- [Cases Reference](#cases-reference)
  - [OpenAI — GPT-5](#openai--gpt-5-family)
  - [OpenAI — GPT-4.1](#openai--gpt-41-family)
  - [OpenAI — GPT-4o](#openai--gpt-4o-family)
  - [OpenAI — Reasoning (o-series)](#openai--reasoning-o-series)
  - [OpenAI — Image Generation](#openai--image-generation)
  - [OpenAI — Text-to-Speech](#openai--text-to-speech)
  - [OpenAI — Transcription](#openai--transcription)
  - [OpenAI — Embeddings](#openai--embeddings)
  - [OpenAI — Moderation](#openai--moderation)
  - [Claude (Anthropic) — 4.6 Generation](#claude-anthropic--46-generation-current)
  - [Claude (Anthropic) — 4.5 Generation](#claude-anthropic--45-generation)
  - [Claude (Anthropic) — 4.1 Generation](#claude-anthropic--41-generation)
  - [Claude (Anthropic) — 4.0 Generation](#claude-anthropic--40-generation)
  - [Claude (Anthropic) — 3.7 Generation](#claude-anthropic--37-generation)
  - [Claude (Anthropic) — 3.5 Generation](#claude-anthropic--35-generation-legacy)
  - [Ollama — Llama](#ollama--llama-family-meta)
  - [Ollama — Gemma](#ollama--gemma-family-google)
  - [Ollama — Mistral / Mixtral](#ollama--mistral--mixtral)
  - [Ollama — Qwen](#ollama--qwen-family-alibaba)
  - [Ollama — DeepSeek](#ollama--deepseek-family)
  - [Ollama — Phi](#ollama--phi-family-microsoft)
  - [Ollama — Coding Models](#ollama--coding-models)
  - [Ollama — Vision Models](#ollama--vision-models)
  - [Ollama — Embedding Models](#ollama--embedding-models)
- [Built-in Enum Methods](#built-in-enum-methods)
  - [`from()`](#fromstring-modelid-self)
  - [`tryFrom()`](#tryfromstring-modelid-self)
  - [`cases()`](#cases-self)
- [Instance Methods](#instance-methods)
  - [`client()`](#client-string)
  - [`capabilities()`](#capabilities-array)
  - [`isVision()`](#isvision-bool)
  - [`isReasoning()`](#isreasoning-bool)
  - [`isEmbedding()`](#isembedding-bool)
  - [`isChat()`](#ischat-bool)
  - [`isCoding()`](#iscoding-bool)
  - [`isFineTunable()`](#isfinetunable-bool)
- [Static Methods](#static-methods)
  - [`forClient()`](#forclientstring-client-self)
  - [`forCapability()`](#forcapabilitystring-capability-self)
  - [`resolve()`](#resolvestring-modelid-self)
- [Usage Examples](#usage-examples)
  - [Basic Usage](#basic-usage)
  - [Type-Safe Function Signatures](#type-safe-function-signatures)
  - [Resolving from Config or User Input](#resolving-from-config-or-user-input)
  - [Exhaustive match on Cases](#exhaustive-match-on-cases)
  - [Routing by Client](#routing-by-client)
  - [Guarding Capability Requirements](#guarding-capability-requirements)
  - [Building UI Select Lists](#building-ui-select-lists)
  - [Pinned vs. Alias Snapshots](#pinned-vs-alias-snapshots)
- [Comparison with the Class Version](#comparison-with-the-class-version)

---

## Why an Enum?

| Feature | `const class Model` | `enum Model: string` |
|---|:---:|:---:|
| Eliminate raw string typos | ✅ | ✅ |
| IDE autocompletion | ✅ | ✅ |
| Type-safe parameter hints (`Model $m`) | ❌ | ✅ |
| Built-in `from()` / `tryFrom()` | ❌ | ✅ |
| Built-in `cases()` iteration | ❌ | ✅ |
| Exhaustive `match` enforcement | ❌ | ✅ |
| Instance methods on a case | ❌ | ✅ |
| Requires reflection for `all()` | ✅ | ❌ |
| Can be used in attributes | ❌ | ✅ |

Choose the **enum** when you want PHP to enforce correctness at the type level; choose the **class** when you need to target PHP < 8.1 or prefer the `Model::GPT_4` constant call style without `->value`.

---

## Import

```php
use Luminova\AI\Model;
```

---

## Naming Convention

| Rule | Example |
|---|---|
| Hyphens and dots → underscores | `gpt-4.1-mini` → `GPT_4_1_MINI` |
| Size tag suffix (`:8b`) | `llama3.1:8b` → `LLAMA_3_1_8B` |
| MoE tag (`8x7b`) | `mixtral:8x7b` → `MIXTRAL_8X7B` |
| Versioned snapshot | `claude-opus-4-5-20251101` → `CLAUDE_OPUS_4_5_SNAP` |
| Clean alias alongside snapshot | `claude-opus-4-5` → `CLAUDE_OPUS_4_5` |

---

## Getting the API String

Every client method that accepts a `model` parameter expects a plain `string`. Use `->value` to extract the API string from a case:

```php
// Correct — pass ->value to the client
$ai->message('Hello!', ['model' => Model::GPT_4_1_MINI->value]);

// Also correct when your method accepts Model directly and extracts ->value internally
function chat(Model $model, string $prompt): array {
    return $ai->message($prompt, ['model' => $model->value]);
}
```

---

## Cases Reference

### OpenAI — GPT-5 Family

| Case | `->value` | Notes |
|---|---|---|
| `Model::GPT_5` | `gpt-5` | Flagship model. Complex reasoning, multimodal, 256 K context. |
| `Model::GPT_5_MINI` | `gpt-5-mini` | Faster, more affordable GPT-5 variant. |
| `Model::GPT_5_NANO` | `gpt-5-nano` | Smallest GPT-5; optimized for latency and cost. |

### OpenAI — GPT-4.1 Family

| Case | `->value` | Notes |
|---|---|---|
| `Model::GPT_4_1` | `gpt-4.1` | 1 M token context, instruction-following, coding. Supports fine-tuning. |
| `Model::GPT_4_1_MINI` | `gpt-4.1-mini` | **Default chat model** for the Luminova OpenAI client. Supports fine-tuning. |
| `Model::GPT_4_1_NANO` | `gpt-4.1-nano` | Fastest / cheapest GPT-4.1. Supports fine-tuning. |

### OpenAI — GPT-4o Family

| Case | `->value` | Notes |
|---|---|---|
| `Model::GPT_4O` | `gpt-4o` | Multimodal (text + image + audio). 128 K context. |
| `Model::GPT_4O_MINI` | `gpt-4o-mini` | Lightweight GPT-4o. 128 K context. |
| `Model::GPT_4O_AUDIO` | `gpt-4o-audio-preview` | Native audio I/O. |
| `Model::GPT_4O_MINI_AUDIO` | `gpt-4o-mini-audio-preview` | Lower-cost audio variant. |
| `Model::GPT_4O_REALTIME` | `gpt-4o-realtime-preview` | Low-latency real-time speech and text. |
| `Model::GPT_4O_MINI_REALTIME` | `gpt-4o-mini-realtime-preview` | Lower-cost realtime variant. |
| `Model::COMPUTER_USE` | `computer-use-preview` | GUI interaction via the Responses API. |

### OpenAI — Reasoning (o-series)

| Case | `->value` | Notes |
|---|---|---|
| `Model::O3` | `o3` | Most capable reasoning model. Supports visual reasoning. |
| `Model::O3_PRO` | `o3-pro` | o3 with extra compute for critical tasks. |
| `Model::O3_DEEP_RESEARCH` | `o3-deep-research` | Multi-step web and document research. |
| `Model::O4_MINI` | `o4-mini` | Fast reasoning; top benchmark for math/coding/vision. |
| `Model::O4_MINI_DEEP_RESEARCH` | `o4-mini-deep-research` | Deep research variant of o4 Mini. |

### OpenAI — Image Generation

| Case | `->value` | Notes |
|---|---|---|
| `Model::GPT_IMAGE_1_5` | `gpt-image-1.5` | Latest image model. High-resolution + inpainting. Requires approval. |
| `Model::GPT_IMAGE_1` | `gpt-image-1` | **Default image model** for the Luminova OpenAI client. Requires approval. |
| `Model::DALL_E_3` | `dall-e-3` | Generally available. Up to 1792×1024 px. |
| `Model::DALL_E_2` | `dall-e-2` | Previous generation; lower cost. |

### OpenAI — Text-to-Speech

| Case | `->value` | Notes |
|---|---|---|
| `Model::GPT_4O_MINI_TTS` | `gpt-4o-mini-tts` | **Default TTS model.** Voices: `alloy`, `echo`, `fable`, `onyx`, `nova`, `shimmer`. |
| `Model::TTS_1` | `tts-1` | Optimized for real-time use. |
| `Model::TTS_1_HD` | `tts-1-hd` | Higher quality, more natural intonation. |

### OpenAI — Transcription

| Case | `->value` | Notes |
|---|---|---|
| `Model::GPT_4O_TRANSCRIBE` | `gpt-4o-transcribe` | Superior accuracy, multilingual. |
| `Model::GPT_4O_MINI_TRANSCRIBE` | `gpt-4o-mini-transcribe` | Faster, lower-cost. Currently recommended. |
| `Model::WHISPER_1` | `whisper-1` | **Default transcription model.** 99+ languages. |

### OpenAI — Embeddings

| Case | `->value` | Notes |
|---|---|---|
| `Model::TEXT_EMBEDDING_3_LARGE` | `text-embedding-3-large` | Highest accuracy. 3072-dimensional (reducible). Best for RAG. |
| `Model::TEXT_EMBEDDING_3_SMALL` | `text-embedding-3-small` | **Default embedding model.** 1536-dimensional. |
| `Model::TEXT_EMBEDDING_ADA_002` | `text-embedding-ada-002` | Legacy. Prefer `TEXT_EMBEDDING_3_SMALL` for new work. |

### OpenAI — Moderation

| Case | `->value` | Notes |
|---|---|---|
| `Model::OMNI_MODERATION` | `omni-moderation-latest` | Text + image moderation. |
| `Model::TEXT_MODERATION` | `text-moderation-latest` | Text-only moderation. |

---

### Claude (Anthropic) — 4.6 Generation *(current)*

| Case | `->value` | Notes |
|---|---|---|
| `Model::CLAUDE_OPUS_4_6` | `claude-opus-4-6` | Most capable. ~14.5 h task horizon. 1 M context (beta). |
| `Model::CLAUDE_SONNET_4_6` | `claude-sonnet-4-6` | **Default Claude model.** Preferred by developers over previous Opus. |

### Claude (Anthropic) — 4.5 Generation

| Case | `->value` | Notes |
|---|---|---|
| `Model::CLAUDE_OPUS_4_5` | `claude-opus-4-5` | 67% price cut; 76% fewer output tokens vs previous Opus. |
| `Model::CLAUDE_OPUS_4_5_SNAP` | `claude-opus-4-5-20251101` | Pinned snapshot — guaranteed reproducibility. |
| `Model::CLAUDE_SONNET_4_5` | `claude-sonnet-4-5` | Industry-leading agent capabilities. |
| `Model::CLAUDE_HAIKU_4_5` | `claude-haiku-4-5` | Fastest, most cost-effective Claude 4.5. |
| `Model::CLAUDE_HAIKU_4_5_SNAP` | `claude-haiku-4-5-20251001` | Pinned snapshot. |

### Claude (Anthropic) — 4.1 Generation

| Case | `->value` | Notes |
|---|---|---|
| `Model::CLAUDE_OPUS_4_1` | `claude-opus-4-1` | Industry leader for coding and long-horizon agentic tasks. |
| `Model::CLAUDE_OPUS_4_1_SNAP` | `claude-opus-4-1-20250805` | Pinned snapshot. |
| `Model::CLAUDE_SONNET_4_1` | `claude-sonnet-4-1` | Production-ready agents at scale. |

### Claude (Anthropic) — 4.0 Generation

| Case | `->value` | Notes |
|---|---|---|
| `Model::CLAUDE_OPUS_4` | `claude-opus-4-0` | First Claude 4-gen Opus. State-of-the-art coding at release. |
| `Model::CLAUDE_SONNET_4` | `claude-sonnet-4-0` | First Claude 4-gen Sonnet. Fast and context-aware. |

### Claude (Anthropic) — 3.7 Generation

| Case | `->value` | Notes |
|---|---|---|
| `Model::CLAUDE_SONNET_3_7` | `claude-sonnet-3-7` | Introduced extended (hybrid) thinking. |
| `Model::CLAUDE_SONNET_3_7_SNAP` | `claude-3-7-sonnet-20250219` | Pinned snapshot. |

### Claude (Anthropic) — 3.5 Generation *(legacy)*

| Case | `->value` | Notes |
|---|---|---|
| `Model::CLAUDE_SONNET_3_5` | `claude-3-5-sonnet-20241022` | Upgraded Sonnet with computer use (Oct 2024). |
| `Model::CLAUDE_HAIKU_3_5` | `claude-3-5-haiku-20241022` | Lightweight, fast. Ideal for rapid completions. |

---

### Ollama — Llama Family (Meta)

| Case | `->value` | Notes |
|---|---|---|
| `Model::LLAMA_3` | `llama3` | Baseline Llama 3 (8 B). Most widely deployed. |
| `Model::LLAMA_3_1` | `llama3.1` | 128 K context support. |
| `Model::LLAMA_3_1_8B` | `llama3.1:8b` | Explicit 8 B tag. |
| `Model::LLAMA_3_1_70B` | `llama3.1:70b` | Large-scale; multi-GPU or high-VRAM. |
| `Model::LLAMA_3_2` | `llama3.2` | Compact (1 B / 3 B). Optimised for edge hardware. |
| `Model::LLAMA_3_2_1B` | `llama3.2:1b` | Ultra-compact for edge and embedded use. |
| `Model::LLAMA_3_2_3B` | `llama3.2:3b` | Small but capable for CLI copilots. |
| `Model::LLAMA_3_3` | `llama3.3` | Latest large Llama (70 B). Excellent long-form chat. |
| `Model::LLAMA_3_3_70B` | `llama3.3:70b` | Explicit 70 B tag. |

### Ollama — Gemma Family (Google)

| Case | `->value` | Notes |
|---|---|---|
| `Model::GEMMA_3` | `gemma3` | Current-gen (1 B–27 B). 128 K context; vision-capable (4 B+). |
| `Model::GEMMA_3_4B` | `gemma3:4b` | Vision-capable; fits 8 GB VRAM. |
| `Model::GEMMA_3_12B` | `gemma3:12b` | 12–16 GB VRAM sweet spot. |
| `Model::GEMMA_3_27B` | `gemma3:27b` | Flagship Gemma 3 variant. |
| `Model::GEMMA_2` | `gemma2` | Previous gen; proven reliability (2 B, 9 B, 27 B). |
| `Model::GEMMA_2_2B` | `gemma2:2b` | Smallest Gemma 2; edge deployments. |
| `Model::GEMMA_2_9B` | `gemma2:9b` | Good performance within 10 GB VRAM. |
| `Model::GEMMA_2_27B` | `gemma2:27b` | Creative and NLP-focused tasks. |

### Ollama — Mistral / Mixtral

| Case | `->value` | Notes |
|---|---|---|
| `Model::MISTRAL` | `mistral` | Fast 7 B model with strong European language support. |
| `Model::MISTRAL_7B` | `mistral:7b` | Explicit 7 B tag. |
| `Model::MIXTRAL_8X7B` | `mixtral:8x7b` | Mixture-of-Experts; 2 experts active per token. |
| `Model::MIXTRAL_8X22B` | `mixtral:8x22b` | Larger MoE; near-frontier quality for local hardware. |

### Ollama — Qwen Family (Alibaba)

| Case | `->value` | Notes |
|---|---|---|
| `Model::QWEN_3` | `qwen3` | Latest generation. Up to 256 K context; strong multilingual. |
| `Model::QWEN_3_4B` | `qwen3:4b` | Compact; fits low-VRAM hardware. |
| `Model::QWEN_3_14B` | `qwen3:14b` | Mid-range; single consumer GPU. |
| `Model::QWEN_3_72B` | `qwen3:72b` | Maximum capability; enterprise-grade. |
| `Model::QWEN_2_5` | `qwen2.5` | Previous gen; 18 T tokens; 128 K context. |
| `Model::QWEN_2_5_7B` | `qwen2.5:7b` | |
| `Model::QWEN_2_5_14B` | `qwen2.5:14b` | |
| `Model::QWEN_2_5_CODER` | `qwen2.5-coder` | Coding-focused; 87 languages; matches GPT-4o at 32 B. |
| `Model::QWEN_2_5_CODER_7B` | `qwen2.5-coder:7b` | Excellent code quality on limited hardware. |
| `Model::QWEN_2_5_CODER_32B` | `qwen2.5-coder:32b` | Best local coding model at this scale. |

### Ollama — DeepSeek Family

| Case | `->value` | Notes |
|---|---|---|
| `Model::DEEPSEEK_R1` | `deepseek-r1` | Open reasoning model; matches o3 on key benchmarks. |
| `Model::DEEPSEEK_R1_7B` | `deepseek-r1:7b` | Smallest R1; 8–10 GB VRAM. |
| `Model::DEEPSEEK_R1_14B` | `deepseek-r1:14b` | Best mid-range reasoning for home labs. |
| `Model::DEEPSEEK_R1_32B` | `deepseek-r1:32b` | 24 GB+ VRAM setups. |
| `Model::DEEPSEEK_R1_70B` | `deepseek-r1:70b` | Near-frontier; multi-GPU recommended. |
| `Model::DEEPSEEK_CODER` | `deepseek-coder` | 87 programming languages; 2 T training tokens. |
| `Model::DEEPSEEK_CODER_33B` | `deepseek-coder:33b` | Top-quality local code generation. |

### Ollama — Phi Family (Microsoft)

| Case | `->value` | Notes |
|---|---|---|
| `Model::PHI_4` | `phi4` | Latest lightweight model; 14 B, 128 K context. |
| `Model::PHI_4_14B` | `phi4:14b` | Explicit 14 B tag. |
| `Model::PHI_3` | `phi3` | Previous gen (3.8 B Mini / 14 B Medium). |
| `Model::PHI_3_MINI` | `phi3:mini` | 3.8 B; suitable for on-device and IoT. |

### Ollama — Coding Models

| Case | `->value` | Notes |
|---|---|---|
| `Model::CODE_LLAMA` | `codellama` | Meta's code-focused Llama (7 B–70 B). Fill-in-the-middle support. |
| `Model::CODE_LLAMA_13B` | `codellama:13b` | Good balance of code quality and hardware. |
| `Model::CODE_LLAMA_34B` | `codellama:34b` | High-quality generation for 24 GB VRAM. |

### Ollama — Vision Models

| Case | `->value` | Notes |
|---|---|---|
| `Model::LLAVA` | `llava` | **Default vision model** for the Luminova Ollama client. |
| `Model::LLAVA_13B` | `llava:13b` | Stronger vision understanding. |
| `Model::LLAVA_34B` | `llava:34b` | Highest-quality LLaVA; 24+ GB VRAM. |
| `Model::LLAMA_3_2_VISION` | `llama3.2-vision` | Better structured-output than LLaVA. |
| `Model::MOONDREAM` | `moondream` | Tiny (1.8 B); edge devices; fast captioning. |
| `Model::BAKLLAVA` | `bakllava` | Mistral-7B base with LLaVA multimodal fine-tuning. |

### Ollama — Embedding Models

| Case | `->value` | Notes |
|---|---|---|
| `Model::NOMIC_EMBED_TEXT` | `nomic-embed-text` | **Default embedding model.** 8 K context; strong MTEB scores. |
| `Model::MXBAI_EMBED_LARGE` | `mxbai-embed-large` | 1024-dimensional; competitive with OpenAI's large model. |
| `Model::ALL_MINILM` | `all-minilm` | 384-dimensional; very fast similarity search. |

---

## Built-in Enum Methods

These are standard PHP 8.1 backed-enum methods available on every string-backed enum automatically.

### `from(string $modelId): self`

Resolve a case from its API string value. **Throws `\ValueError`** when the string is not a known case — use this when the input is trusted.

```php
$model = Model::from('gpt-4.1-mini');  // Model::GPT_4_1_MINI
$model = Model::from('unknown');        // throws \ValueError
```

---

### `tryFrom(string $modelId): ?self`

Resolve a case from its API string value. **Returns `null`** when the string is not known — use this for user or config input.

```php
$model = Model::tryFrom('gpt-4.1-mini'); // Model::GPT_4_1_MINI
$model = Model::tryFrom('unknown');       // null
```

---

### `cases(): self[]`

Return all cases as an array of enum instances. The order matches declaration order in the source file.

```php
foreach (Model::cases() as $model) {
    echo $model->name . ' => ' . $model->value . PHP_EOL;
}
// GPT_5 => gpt-5
// GPT_5_MINI => gpt-5-mini
// ...
// ALL_MINILM => all-minilm
```

> **Note:** `cases()` returns only enum cases, never private constants like `PROVIDER_MAP` or `CAPABILITY_MAP`.

---

## Instance Methods

Called directly on a case — no arguments needed.

### `client(): string`

Return the client short-name. Matches the key registered in `AI::$clients`: `'openai'`, `'anthropic'`, or `'ollama'`.

```php
Model::GPT_4_1_MINI->client();      // 'openai'
Model::CLAUDE_SONNET_4_6->client(); // 'anthropic'
Model::LLAVA->client();             // 'ollama'
Model::DEEPSEEK_R1->client();       // 'ollama'
```

---

### `capabilities(): array`

Return all capability tags this case supports.

**Available tags:** `chat`, `vision`, `image`, `embedding`, `speech`, `transcription`, `reasoning`, `coding`, `fine-tuning`, `moderation`.

```php
Model::O3->capabilities();
// ['chat', 'vision', 'reasoning', 'coding']

Model::GPT_4_1_MINI->capabilities();
// ['chat', 'vision', 'coding', 'fine-tuning']

Model::NOMIC_EMBED_TEXT->capabilities();
// ['embedding']

Model::DALL_E_3->capabilities();
// ['image']

Model::WHISPER_1->capabilities();
// ['transcription']
```

---

### `isVision(): bool`

Whether this case accepts image input.

```php
Model::GPT_4_1->isVision();          // true
Model::LLAVA->isVision();            // true
Model::NOMIC_EMBED_TEXT->isVision(); // false
Model::WHISPER_1->isVision();        // false
```

---

### `isReasoning(): bool`

Whether this is a reasoning / chain-of-thought model.

```php
Model::O3->isReasoning();            // true
Model::O3_PRO->isReasoning();        // true
Model::DEEPSEEK_R1->isReasoning();   // true
Model::CLAUDE_SONNET_3_7->isReasoning(); // true
Model::GPT_4_1_MINI->isReasoning();  // false
```

---

### `isEmbedding(): bool`

Whether this case produces vector embeddings.

```php
Model::TEXT_EMBEDDING_3_SMALL->isEmbedding(); // true
Model::NOMIC_EMBED_TEXT->isEmbedding();       // true
Model::MXBAI_EMBED_LARGE->isEmbedding();      // true
Model::GPT_4_1->isEmbedding();               // false
```

---

### `isChat(): bool`

Whether this case supports chat / completion.

```php
Model::GPT_4_1_MINI->isChat(); // true
Model::LLAMA_3_2->isChat();    // true
Model::DALL_E_3->isChat();     // false
Model::WHISPER_1->isChat();    // false
```

---

### `isCoding(): bool`

Whether this case is optimized for code generation or completion.

```php
Model::DEEPSEEK_CODER->isCoding();   // true
Model::QWEN_2_5_CODER->isCoding();   // true
Model::CODE_LLAMA->isCoding();       // true
Model::GPT_4_1->isCoding();          // true
Model::LLAVA->isCoding();            // false
```

---

### `isFineTunable(): bool`

Whether this case supports fine-tuning via the client API.

```php
Model::GPT_4_1->isFineTunable();      // true
Model::GPT_4_1_MINI->isFineTunable(); // true
Model::GPT_4_1_NANO->isFineTunable(); // true
Model::O3->isFineTunable();           // false
Model::CLAUDE_SONNET_4_6->isFineTunable(); // false
```

---

## Static Methods

### `forClient(string $client): self[]`

Return all cases belonging to a specific client as an array of enum instances.

```php
$cases = Model::forClient('openai');
// [Model::GPT_5, Model::GPT_5_MINI, ..., Model::TEXT_MODERATION]

$cases = Model::forClient('anthropic');
// [Model::CLAUDE_OPUS_4_6, Model::CLAUDE_SONNET_4_6, ...]

$cases = Model::forClient('ollama');
// [Model::LLAMA_3, Model::LLAMA_3_1, ..., Model::ALL_MINILM]

foreach (Model::forClient('ollama') as $model) {
    echo $model->name . ' = ' . $model->value . PHP_EOL;
}
```

---

### `forCapability(string $capability): self[]`

Return all cases that support a given capability tag as an array of enum instances.

**Available tags:** `chat`, `vision`, `image`, `embedding`, `speech`, `transcription`, `reasoning`, `coding`, `fine-tuning`, `moderation`.

```php
$visionModels    = Model::forCapability('vision');
$embeddingModels = Model::forCapability('embedding');
$reasoningModels = Model::forCapability('reasoning');
$codingModels    = Model::forCapability('coding');
$imageModels     = Model::forCapability('image');

foreach (Model::forCapability('reasoning') as $model) {
    echo $model->value . ' (' . $model->client() . ')' . PHP_EOL;
}
// o3 (openai)
// o3-pro (openai)
// deepseek-r1 (ollama)
// claude-sonnet-3-7 (anthropic)
// ...
```

---

### `resolve(string $modelId): ?self`

A readable alias for `Model::tryFrom()`. Returns the matching case or `null` — never throws. Intended to make call-site intent explicit when validating external input.

```php
$model = Model::resolve('gpt-4.1-mini');  // Model::GPT_4_1_MINI
$model = Model::resolve('bad-string');     // null

// Safe fallback pattern
$model = Model::resolve($config['model']) ?? Model::GPT_4_1_MINI;
```

---

## Usage Examples

### Basic Usage

```php
use Luminova\AI\Model;
use Luminova\AI\AI;

// Chat with OpenAI
$reply = AI::Openai($key)->message('Hello!', [
    'model' => Model::GPT_4_1_MINI->value,
]);

// Chat with Claude
$reply = AI::Anthropic($key)->message('Summarise this.', [
    'model' => Model::CLAUDE_SONNET_4_6->value,
]);

// Local inference with Ollama
$reply = AI::Ollama()->message('Explain closures.', [
    'model' => Model::LLAMA_3_2->value,
]);

// Embeddings
$vector = AI::Openai($key)->embed('Hello world', [
    'model' => Model::TEXT_EMBEDDING_3_SMALL->value,
]);

// Ollama vision
$reply = AI::Ollama()->vision('What is in this image?', '/tmp/photo.jpg', [
    'model' => Model::LLAVA->value,
]);
```

---

### Type-Safe Function Signatures

The enum's biggest advantage — invalid model strings become impossible at the type level:

```php
use Luminova\AI\Model;

function chat(string $prompt, Model $model = Model::GPT_4_1_MINI): array
{
    return AI::getInstance()->message($prompt, ['model' => $model->value]);
}

// Valid calls
chat('Hello!');
chat('Hello!', Model::O3);
chat('Hello!', Model::CLAUDE_OPUS_4_6);
chat('Hello!', Model::LLAMA_3_3);

// Invalid — PHP type error at call time, not a runtime client error
chat('Hello!', 'gpt-4.1-mini');  // TypeError: Argument 2 must be of type Model
```

---

### Resolving from Config or User Input

```php
// From a config file
$configured = $config->get('ai.model', 'gpt-4.1-mini');
$model = Model::resolve($configured) ?? Model::GPT_4_1_MINI;

echo "Using: {$model->value} ({$model->client()})";

// From a web request — reject unknown values
$userModel = $_POST['model'] ?? '';
$model = Model::tryFrom($userModel);

if ($model === null) {
    http_response_code(400);
    exit("Unknown model: {$userModel}");
}

$reply = $ai->message($prompt, ['model' => $model->value]);
```

---

### Exhaustive `match` on Cases

PHP enforces that all cases in a `match` are handled when matching on an enum. This prevents silent omissions as you add new cases:

```php
$model = Model::CLAUDE_SONNET_4_6;

$tier = match ($model) {
    Model::GPT_5, Model::CLAUDE_OPUS_4_6, Model::O3_PRO     => 'flagship',
    Model::GPT_4_1, Model::CLAUDE_SONNET_4_6, Model::O3     => 'standard',
    Model::GPT_4_1_MINI, Model::CLAUDE_HAIKU_4_5, Model::O4_MINI => 'efficient',
    default => 'other',
};
```

---

### Routing by Provider

```php
use Luminova\AI\AI;
use Luminova\AI\Model;

function chat(string $prompt, Model $model): array
{
    return match ($model->client()) {
        'openai'    => AI::Openai($_ENV['OPENAI_KEY'])->message($prompt, ['model' => $model->value]),
        'anthropic' => AI::Anthropic($_ENV['ANTHROPIC_KEY'])->message($prompt, ['model' => $model->value]),
        'ollama'    => AI::Ollama()->message($prompt, ['model' => $model->value]),
    };
}

chat('Tell me a joke.', Model::GPT_4_1_MINI);      // OpenAI
chat('Tell me a joke.', Model::CLAUDE_SONNET_4_6); // Anthropic
chat('Tell me a joke.', Model::LLAMA_3_2);         // Ollama
```

---

### Guarding Capability Requirements

```php
use Luminova\AI\Model;

function analyzeImage(string $prompt, string $imagePath, Model $model): array
{
    if (!$model->isVision()) {
        throw new RuntimeException(
            "Model '{$model->value}' does not support vision. " .
            'Try Model::GPT_4_1, Model::LLAVA, or Model::LLAMA_3_2_VISION.'
        );
    }

    return AI::getInstance()->vision($prompt, $imagePath, ['model' => $model->value]);
}

analyzeImage('What breed is this?', '/tmp/dog.jpg', Model::GPT_4_1);   // OK
analyzeImage('What breed is this?', '/tmp/dog.jpg', Model::WHISPER_1); // throws
```

```php
function embed(string $text, Model $model = Model::TEXT_EMBEDDING_3_SMALL): array
{
    if (!$model->isEmbedding()) {
        throw new RuntimeException("'{$model->value}' is not an embedding model.");
    }

    return AI::getInstance()->embed($text, ['model' => $model->value]);
}
```

---

### Building UI Select Lists

```php
// All available models grouped by client for a settings page
$grouped = [];

foreach (Model::cases() as $model) {
    $grouped[$model->client()][] = [
        'value' => $model->value,
        'label' => str_replace('_', ' ', ucfirst(strtolower($model->name))),
        'tags'  => $model->capabilities(),
    ];
}

// Only offer vision-capable models in a vision task dropdown
$visionOptions = array_map(
    fn(Model $m): array => ['value' => $m->value, 'label' => $m->name],
    Model::forCapability('vision')
);
```

---

### Pinned vs. Alias Snapshots

For Claude models, Anthropic recommends using versioned snapshot strings in production to guarantee reproducible behavior. Luminova provides both:

```php
// Always-latest alias — may quietly change behavior when Anthropic updates it
$model = Model::CLAUDE_OPUS_4_5;        // 'claude-opus-4-5'

// Pinned snapshot — behavior is frozen to the exact release
$model = Model::CLAUDE_OPUS_4_5_SNAP;   // 'claude-opus-4-5-20251101'
```

Use the **alias** in development for the newest behavior; use the **snapshot** in staging/production for determinism.

---

## Comparison with the Class Version

| Aspect | `class Model` | `enum Model: string` |
|---|---|---|
| Access a model string | `Model::GPT_4_1_MINI` | `Model::GPT_4_1_MINI->value` |
| Type-hint a parameter | `string $model` | `Model $model` |
| Resolve from a string | `Model::exists($s)` + use `$s` | `Model::tryFrom($s)` → `Model|null` |
| Iterate all models | `Model::all()` (reflection) | `Model::cases()` (built-in) |
| Check client | `Model::client($id)` | `Model::GPT_4_1->client()` |
| Check capability | `Model::isVision($id)` | `Model::GPT_4_1->isVision()` |
| Filter by client | `Model::forProvider('openai')` → `string[]` | `Model::forProvider('openai')` → `Model[]` |
| Filter by capability | `Model::forCapability('vision')` → `string[]` | `Model::forCapability('vision')` → `Model[]` |
| `match` exhaustiveness | ❌ | ✅ |
| Use in PHP attributes | ❌ | ✅ |
| PHP requirement | 8.0+ (reflection only) | 8.1+ |

Both classes expose identical client data and capability tags. The **enum** is recommended for all new code.

---

## See Also

- [`Luminova\AI\Model` (class version)](https://github.com/luminovang/php-ai-models) — Static constants for PHP style or pre-8.1 compatibility.
