import cv2
import face_recognition
import os
import mysql.connector


dir_path = "C:/Users/admin/Desktop/9raya/machine learning/movie_face_detection_project_php/wanted faces"
L = os.listdir(dir_path)

known_face_encodings = []
known_face_names = []
for folder in L:
    folder_path = dir_path + "/" + folder
    L2 = os.listdir(folder_path)
    for pic in L2:
        try:
            picture_path = folder_path + "/" + pic
            picture = face_recognition.load_image_file(picture_path)
            picture_face_encoding = face_recognition.face_encodings(picture)[0]

            known_face_encodings.append(picture_face_encoding)

            known_face_names.append(folder)
        except:
            continue

wanted_dir_path = "C:/Users/admin/Desktop/9raya/machine learning/movie_face_detection_project_php/wanted"
L = os.listdir(wanted_dir_path)
wanted_pic_path = wanted_dir_path + "/" + str(L[0])

wanted_pic = cv2.imread(wanted_pic_path, -1)

face_locations = face_recognition.face_locations(wanted_pic)
face_encodings = face_recognition.face_encodings(wanted_pic, face_locations)

config = {
    'user': 'root',
    'password': 'root',
    'host': 'localhost',
    'database': 'wanted',
    'raise_on_warnings': True,
}

con = mysql.connector.connect(**config)

cur = con.cursor()
cur.execute("DELETE FROM `wanted_result`")
cin_list = []
for (top, right, bottom, left), face_encoding in zip(face_locations, face_encodings):
    matches = face_recognition.compare_faces(known_face_encodings, face_encoding)
    if True in matches:
        for k in range(len(matches)):
            if (matches[k]):
                first_match_index = k
                cin = known_face_names[first_match_index]

                cur.execute("SELECT * FROM `wanted` WHERE `cin`='" + str(cin) + "'")
                result = cur.fetchall()

                for row in result:
                    cin = row[2]
                    cin_list.append(cin)
                    name = row[1]
                    picture = ""
                    for i in row[3][:-1]:
                        if (i=='-'):
                            break
                        picture = picture + i
                    if(cin_list.count(cin)<=1):
                        cur.execute("INSERT INTO `wanted_result` (`name`, `cin`, `imagename`) VALUES ('" + name + "', '" + cin + "', '" + picture + "')")

cur.close()
con.commit()
con.close()
