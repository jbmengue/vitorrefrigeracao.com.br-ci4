// eslint.config.mjs
import js from '@eslint/js';
import tseslint from 'typescript-eslint';
import react from 'eslint-plugin-react';
import reactHooks from 'eslint-plugin-react-hooks';
import perfectionist from 'eslint-plugin-perfectionist';
import prettier from 'eslint-plugin-prettier';

export default [
  // Regras base do ESLint
  js.configs.recommended,

  // TypeScript (flat) – sem type-aware pra simplificar
  ...tseslint.configs.recommended,

  // Bloco comum a TS/JS/JSX/TSX
  {
    files: ['**/*.{js,jsx,ts,tsx}'],

    plugins: {
      react,
      'react-hooks': reactHooks,
      perfectionist,
      prettier,
    },

    settings: {
      react: { version: 'detect' },
    },

    rules: {
      // React (apenas as rules, para não carregar objetos com plugins internos)
      ...(react.configs['flat/recommended']?.rules ?? react.configs.recommended.rules),
      ...(react.configs['flat/jsx-runtime']?.rules ?? react.configs['jsx-runtime']?.rules),

      // React Hooks
      ...(reactHooks.configs['flat/recommended']?.rules ?? reactHooks.configs.recommended.rules),

      'perfectionist/sort-imports': [
        'error',
        {
          type: 'alphabetical',
          order: 'asc',
          fallbackSort: { type: 'unsorted' },
          ignoreCase: true,
          specialCharacters: 'keep',
          internalPattern: ['^~/.+', '^@/.+'],
          partitionByComment: false,
          partitionByNewLine: false,
          newlinesBetween: 1,
          maxLineLength: undefined,
          groups: [
            'type-import',
            ['value-builtin', 'value-external'],
            'type-internal',
            'value-internal',
            ['type-parent', 'type-sibling', 'type-index'],
            ['value-parent', 'value-sibling', 'value-index'],
            'ts-equals-import',
            'unknown',
          ],
          customGroups: [],
          environment: 'node',
        },
      ],

      'perfectionist/sort-exports': [
        'error',
        {
          type: 'alphabetical',
          order: 'asc',
          fallbackSort: { type: 'unsorted' },
          ignoreCase: true,
          specialCharacters: 'keep',
          partitionByComment: false,
          partitionByNewLine: false,
          newlinesBetween: 'ignore',
          groupKind: 'mixed',
          groups: [],
          customGroups: [],
        },
      ],

      'prettier/prettier': 'error',
    },
  },

  {
    ignores: ['node_modules/', 'dist/', 'build/', 'coverage/', '**/*.d.ts'],
  },
];
