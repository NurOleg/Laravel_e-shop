INSERT INTO public.migrations (id, migration, batch) VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO public.migrations (id, migration, batch) VALUES (2, '2018_07_19_131149_create_cities_table', 1);
INSERT INTO public.migrations (id, migration, batch) VALUES (3, '2018_07_19_131207_create_teammates_table', 1);
INSERT INTO public.migrations (id, migration, batch) VALUES (4, '2018_07_20_090417_create_articles_table', 2);
INSERT INTO public.migrations (id, migration, batch) VALUES (5, '2018_09_20_124256_create_goods_table', 3);
INSERT INTO public.migrations (id, migration, batch) VALUES (6, '2018_09_20_143149_create_categories_table', 3);
INSERT INTO public.migrations (id, migration, batch) VALUES (7, '2018_09_20_144951_drop_categories_table', 4);
INSERT INTO public.migrations (id, migration, batch) VALUES (8, '2018_09_20_150115_update_categories_table', 5);
INSERT INTO public.migrations (id, migration, batch) VALUES (9, '2018_09_24_080139_add_category_to_goods', 6);
INSERT INTO public.migrations (id, migration, batch) VALUES (10, '2018_09_24_120145_create_images_table', 6);
INSERT INTO public.migrations (id, migration, batch) VALUES (11, '2018_09_26_070237_create_categories_table', 7);
INSERT INTO public.migrations (id, migration, batch) VALUES (12, '2018_09_26_070824_add_sync_id_categories_table', 8);
INSERT INTO public.migrations (id, migration, batch) VALUES (17, '2018_09_26_075237_update_categories_name_column', 9);
INSERT INTO public.migrations (id, migration, batch) VALUES (18, '2018_09_26_103743_add_categories_active_column', 9);
INSERT INTO public.migrations (id, migration, batch) VALUES (19, '2018_09_27_070523_create_cache_table', 10);
INSERT INTO public.migrations (id, migration, batch) VALUES (20, '2018_09_28_064826_update_goods_code_cloumn', 11);
INSERT INTO public.migrations (id, migration, batch) VALUES (21, '2018_09_28_065444_update_goods_src_img_cloumn', 12);
INSERT INTO public.migrations (id, migration, batch) VALUES (22, '2018_10_05_140412_create_goods_table', 13);
INSERT INTO public.migrations (id, migration, batch) VALUES (23, '2018_10_05_141236_create_sku_table', 14);
INSERT INTO public.migrations (id, migration, batch) VALUES (24, '2018_10_08_065034_drop_img_column_from_goods_table', 15);
INSERT INTO public.migrations (id, migration, batch) VALUES (25, '2018_10_08_065235_drop_img_column_from_goods_table', 16);
INSERT INTO public.migrations (id, migration, batch) VALUES (26, '2018_10_08_074547_drop_src_column_images_table', 17);
INSERT INTO public.migrations (id, migration, batch) VALUES (27, '2018_10_08_074813_drop_alttitle_columns_add_element_id_column', 18);
INSERT INTO public.migrations (id, migration, batch) VALUES (28, '2018_10_08_083713_add_count_column_sku_table', 19);
INSERT INTO public.migrations (id, migration, batch) VALUES (29, '2018_10_08_092554_update_goods_columns', 20);
INSERT INTO public.migrations (id, migration, batch) VALUES (30, '2018_10_08_093314_drop_size_column_sku', 21);
INSERT INTO public.migrations (id, migration, batch) VALUES (31, '2018_10_08_110006_nullable_columns_sku_table', 22);
INSERT INTO public.migrations (id, migration, batch) VALUES (32, '2018_10_08_141735_create_size_column_images_table', 23);
INSERT INTO public.migrations (id, migration, batch) VALUES (33, '2018_10_09_111626_update_goods_table', 24);
INSERT INTO public.migrations (id, migration, batch) VALUES (34, '2018_10_09_112010_create_count_color_column_goods_table', 25);
INSERT INTO public.migrations (id, migration, batch) VALUES (35, '2018_10_11_080523_add_size_column_sku_table', 26);
INSERT INTO public.migrations (id, migration, batch) VALUES (36, '2018_10_11_132909_create_shoppingcart_table', 27);
INSERT INTO public.migrations (id, migration, batch) VALUES (37, '2018_10_20_124000_create_orders_table', 28);
INSERT INTO public.migrations (id, migration, batch) VALUES (40, '2018_10_20_124753_create_payments_table', 29);
INSERT INTO public.migrations (id, migration, batch) VALUES (41, '2018_10_20_124806_create_delivery_table', 29);
INSERT INTO public.migrations (id, migration, batch) VALUES (42, '2018_10_20_133643_create_shoppingcarts_table', 30);
INSERT INTO public.migrations (id, migration, batch) VALUES (43, '2018_10_20_143407_add_adress_orders_table', 31);
INSERT INTO public.migrations (id, migration, batch) VALUES (44, '2018_10_20_145402_add_admin_column_users_table', 32);
INSERT INTO public.migrations (id, migration, batch) VALUES (45, '2018_10_20_145537_add_phone_column_users_table', 33);