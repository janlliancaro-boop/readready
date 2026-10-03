INSERT IGNORE INTO avatars (id, avatar_name, emoji) VALUES
(1, 'smile', '🙂'),
(2, 'panda', '🐼'),
(3, 'fox', '🦊'),
(4, 'frog', '🐸'),
(5, 'lion', '🦁'),
(6, 'bunny', '🐰');

INSERT IGNORE INTO learners (id, nickname, avatar_id, current_level) VALUES
(1, 'Sunny', 1, 'Beginner');

INSERT IGNORE INTO dictionary_categories (id, name, description) VALUES
(1, 'Animals', 'Animals and pets'),
(2, 'Fruits', 'Tasty fruits to learn'),
(3, 'Vegetables', 'Healthy vegetables'),
(4, 'Colors', 'Color names and shades'),
(5, 'Body Parts', 'Parts of the body'),
(6, 'School Objects', 'Things in a classroom'),
(7, 'Transportation', 'Ways to travel');

INSERT IGNORE INTO dictionary_words (id, word, definition, example_sentence, image_url, category_id) VALUES
(1, 'Apple', 'A round fruit that is crisp and sweet.', 'The apple is red and juicy.', NULL, 2),
(2, 'Dog', 'An animal that barks and plays with people.', 'The dog wags its tail.', NULL, 1),
(3, 'Carrot', 'A long orange vegetable that grows underground.', 'Carrots are good for our eyes.', NULL, 3),
(4, 'Blue', 'The color of the sky and ocean.', 'The sky is blue today.', NULL, 4),
(5, 'Eyes', 'The organs we use to see.', 'I blink my eyes when the light is bright.', NULL, 5),
(6, 'Book', 'A set of pages for reading.', 'I read my book before bed.', NULL, 6),
(7, 'Bus', 'A large vehicle used to carry many people.', 'The bus takes us to school.', NULL, 7),
(8, 'Sun', 'The star that gives light and warmth to Earth.', 'The sun shines brightly in the morning.', NULL, 2);

INSERT IGNORE INTO word_audio (id, word_id, audio_url) VALUES
(1, 1, 'assets/audio/apple.mp3'),
(2, 2, 'assets/audio/dog.mp3'),
(3, 3, 'assets/audio/carrot.mp3'),
(4, 4, 'assets/audio/blue.mp3');

INSERT IGNORE INTO lessons (id, title, lesson_type, description, difficulty) VALUES
(1, 'Alphabet Adventure', 'alphabet', 'Learn the letters A to Z with sound and picture matching.', 'Beginner'),
(2, 'Shape Safari', 'shape', 'Identify shapes and their names.', 'Beginner'),
(3, 'Count and Match', 'numbers', 'Recognize and match numbers from 1 to 100.', 'Intermediate'),
(4, 'Math Journey', 'math', 'Practice basic addition and subtraction.', 'Intermediate'),
(5, 'Word Builder', 'words', 'Build sight words and missing letter patterns.', 'Advanced');

INSERT IGNORE INTO lesson_categories (id, lesson_id, category_name) VALUES
(1, 1, 'Alphabet'),
(2, 2, 'Shapes'),
(3, 3, 'Numbers'),
(4, 4, 'Math'),
(5, 5, 'Words');

INSERT IGNORE INTO quizzes (id, title, category, difficulty) VALUES
(1, 'Alphabet Quiz', 'Alphabet', 'Beginner'),
(2, 'Shape Challenge', 'Shapes', 'Beginner'),
(3, 'Math Adventure Quiz', 'Math', 'Intermediate'),
(4, 'Vocabulary Sprint', 'Words', 'Advanced');

INSERT IGNORE INTO quiz_questions (id, quiz_id, question_text, option_a, option_b, option_c, option_d, correct_answer, question_type) VALUES
(1, 1, 'Which letter comes after A?', 'B', 'C', 'D', 'E', 'B', 'multiple_choice'),
(2, 1, 'The letter S makes the sound /s/?', 'True', 'False', '', '', 'True', 'true_false'),
(3, 2, 'What shape is a ball?', 'Square', 'Circle', 'Triangle', 'Rectangle', 'Circle', 'multiple_choice'),
(4, 3, 'What is 5 + 3?', '7', '8', '9', '10', '8', 'multiple_choice'),
(5, 4, 'Which word means a place to read?', 'Book', 'Door', 'Window', 'Chair', 'Book', 'multiple_choice');

INSERT IGNORE INTO quiz_results (id, learner_id, quiz_id, score, total_questions, percentage) VALUES
(1, 1, 1, 4, 5, 80.00),
(2, 1, 3, 3, 5, 60.00);

INSERT IGNORE INTO spelling_words (id, word, hint, difficulty) VALUES
(1, 'apple', 'A sweet red or green fruit.', 'Beginner'),
(2, 'planet', 'A big object in space.', 'Intermediate'),
(3, 'friend', 'Someone you like and trust.', 'Beginner');

INSERT IGNORE INTO word_puzzles (id, scrambled_word, answer_word, clue, difficulty) VALUES
(1, 'LEPNA', 'APPLE', 'A fruit that is often red or green.', 'Beginner'),
(2, 'SNAH', 'HANS', 'A name used for a friend or classmate.', 'Intermediate');

INSERT IGNORE INTO achievements (id, name, description, icon, reward_points) VALUES
(1, 'Alphabet Explorer', 'Completed the alphabet learning path.', '🏅', 25),
(2, 'Number Master', 'Recognized numbers and counted confidently.', '🔢', 30),
(3, 'Shape Genius', 'Mastered shape recognition.', '🔺', 25),
(4, 'Vocabulary Hero', 'Learned many new words.', '📚', 40),
(5, 'Quiz Champion', 'Won a quiz challenge.', '🏆', 45),
(6, 'Spelling Star', 'Spelled words correctly.', '✨', 35);

INSERT IGNORE INTO rewards (id, learner_id, stars, coins, trophies) VALUES
(1, 1, 245, 320, 7);

INSERT IGNORE INTO learner_progress (id, learner_id, lesson_id, progress_percent, lessons_completed, words_learned, activities_completed) VALUES
(1, 1, 1, 78, 8, 18, 12),
(2, 1, 2, 65, 6, 14, 10),
(3, 1, 4, 72, 7, 12, 9);

INSERT IGNORE INTO activity_logs (id, learner_id, activity_name, activity_type, session_data) VALUES
(1, 1, 'Alphabet Learning', 'lesson', '{"module":"alphabet","score":86}'),
(2, 1, 'Dictionary Search', 'search', '{"word":"apple","search_count":2}'),
(3, 1, 'Quiz Challenge', 'quiz', '{"quiz_id":1,"score":80}');
