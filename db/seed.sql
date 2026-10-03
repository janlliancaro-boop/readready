INSERT IGNORE INTO avatars (id, avatar_name, emoji) VALUES
(1, 'smile', '🙂'),
(2, 'panda', '🐼'),
(3, 'fox', '🦊'),
(4, 'frog', '🐸'),
(5, 'lion', '🦁'),
(6, 'bunny', '🐰');

INSERT IGNORE INTO dictionary_categories (id, name, description, icon, display_order) VALUES
(1, 'Animals', 'Learn about friendly pets and wild animals.', '🐶', 1),
(2, 'Fruits', 'Healthy fruits and tasty treats.', '🍎', 2),
(3, 'Vegetables', 'Fresh vegetables and their colors.', '🥕', 3),
(4, 'Colors', 'Primary and secondary colors.', '🎨', 4),
(5, 'School Objects', 'School tools and classroom items.', '📚', 5),
(6, 'Body Parts', 'Names for parts of the body.', '👀', 6),
(7, 'Transportation', 'Ways to travel every day.', '🚗', 7);

INSERT IGNORE INTO dictionary_words (id, word, definition, example_sentence, image_url, audio_url, category_id) VALUES
(1, 'Apple', 'A round fruit that is crisp and sweet.', 'The apple is red and juicy.', '🍎', NULL, 2),
(2, 'Dog', 'An animal that barks and plays with people.', 'The dog runs in the park.', '🐶', NULL, 1),
(3, 'Carrot', 'A long orange vegetable that grows underground.', 'Carrots are good for our eyes.', '🥕', NULL, 3),
(4, 'Blue', 'The color of the sky and ocean.', 'The sky is blue today.', '🔵', NULL, 4),
(5, 'Book', 'A set of pages for reading.', 'I read my book before bed.', '📘', NULL, 5),
(6, 'Eyes', 'The organs used to see.', 'My eyes are bright and happy.', '👀', NULL, 6),
(7, 'Bus', 'A vehicle used to carry many people.', 'The bus takes us to school.', '🚌', NULL, 7),
(8, 'Sun', 'The star that gives us light and warmth.', 'The sun shines brightly in the morning.', '☀️', NULL, 2);

INSERT IGNORE INTO lessons (id, title, lesson_type, description, difficulty) VALUES
(1, 'Alphabet Adventure', 'alphabet', 'Learn A to Z with pictures and sounds.', 'Beginner'),
(2, 'Shape Safari', 'shape', 'Recognize circles, squares, triangles and more.', 'Beginner'),
(3, 'Count and Match', 'numbers', 'Count, compare, and match numbers confidently.', 'Intermediate'),
(4, 'Math Journey', 'math', 'Practice addition, subtraction, greater than and less than.', 'Intermediate'),
(5, 'Word Builder', 'words', 'Build words with missing letters and picture cues.', 'Advanced');

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

INSERT IGNORE INTO spelling_words (id, word, hint, difficulty) VALUES
(1, 'apple', 'A sweet fruit that can be red or green.', 'Beginner'),
(2, 'planet', 'A huge object in space.', 'Intermediate'),
(3, 'friend', 'Someone you enjoy spending time with.', 'Beginner');

INSERT IGNORE INTO word_puzzles (id, scrambled_word, answer_word, clue, difficulty) VALUES
(1, 'LEPNA', 'APPLE', 'A fruit that is often red or green.', 'Beginner'),
(2, 'HANS', 'SHAN', 'A word used in the phrase "Happy ___".', 'Intermediate');

INSERT IGNORE INTO badges (id, name, description, icon, requirement, stars_reward) VALUES
(1, 'Alphabet Explorer', 'Completed alphabet activities and letter recognition tasks.', '🏅', 'Complete all alphabet activities.', 25),
(2, 'Number Master', 'Recognized and counted numbers confidently.', '🔢', 'Complete number recognition and counting tasks.', 30),
(3, 'Shape Genius', 'Identified and matched common shapes.', '🔺', 'Complete shape recognition activities.', 25),
(4, 'Vocabulary Hero', 'Learned a variety of useful words.', '📚', 'Learn required vocabulary words.', 40),
(5, 'Quiz Champion', 'Reached a strong quiz score.', '🏆', 'Reach a required quiz score.', 45),
(6, 'Spelling Star', 'Spelled words correctly in challenge mode.', '✨', 'Reach required spelling score.', 35);

INSERT IGNORE INTO rewards (id, name, description, icon, stars_award, coins_award, trophy_award) VALUES
(1, 'Starter Reward', 'First-time learner reward for beginning your journey.', '⭐', 25, 10, 1),
(2, 'Vocabulary Reward', 'Awarded after learning more vocabulary.', '🏆', 50, 20, 2),
(3, 'Learning Legend', 'Top milestone reward for consistent effort.', '🎖️', 100, 40, 3);

INSERT IGNORE INTO admins (id, username, password_hash, full_name, role, status) VALUES
(1, 'admin', '$2y$10$P3GfZT8XjGvU4z.sv3U5L.wKBlZKOWPD.3fJ8QZw1r6Qf/RrK3/r2', 'System Administrator', 'super_admin', 'active');

