����������� ������� ��������� ���� � ����� ����������: ������ � �������� �������.

�������� ����������
 - ���������� ������ ���� ��� ������������� ����������� � ���������

������:
 - �������: id, ���������, ��������, �����, url ��������, ���� ����������
 - ���������: ����� ������� � ����

�������������:
 - ������� ����������� ����������� ������� �� ��������� � ���� ����������
 - ��� ���������� �������� ������� ��������� � ���������� ��� ��� �����������
 - � ������� ���������� �������� ����� ������������ Lorem Ipsum ��� ��� ������ ������
 - ������������� ����������� �������� ���������� ���������� ��� �������������� ��������

��������:
 - ���������� �������� � ������ � �� 1 000 000
 - ������������ � 1000 �������� � ������ �������� � ������
 - ����� �������� �������� ������ �������� < 500 ��

����������:
 - ���: PHP, mysql, memcached
 - �����: �� ���� ����������

������ ������ ���� �� ������� � �������� ������� ����������.
� ���������� � ������ �� ������ � ���������� ����

________________________________________________________________________
C����� �� ��� - https://github.com/llvbest/mobi
����������� ���� - http://test.socanalysis.org/

�������� ���������� ������ � ���������������� �� ������� �������, ���� ��������� ���������� 
�� �������� ���. ��������� ���������� (� ��� ��� ������� � ����), ������ ����� ��� ������ �����
pdo � �����, ������������� � ����������� � ������� ��������� ������� � ��, �� ��������� ��������.
�������� ������ ��������� ��������������� �� ������.

���� ������� �� ������� mysql, ��� ������� news MyiSAM �.� ��� � ���������� ������� �������� �������.
�������� ������� �� ���� ��������� � ���� ����������, �.� ��� ����� ����������� � ����������� �� ���� �����.
����� ��������� ������ ���������_����, ��������� ���� ������ ������� �� ���� ����� �����
������������� ������ ������� � �������� ���������� �� ������� � ���� ����������, 
�.� �� ������� ��������� �� ����� � ����� ������� � ���� (�� ��������� ������������� �������, ����� ������ �� ������)

������� ���-�� �������� � ������� ����������� ���������� � memcached �� ���������� �����.

�� ������� �� ������� � ������ ���������� ���������� ��������, ��� ��������� ����������
������� �� ��������� (LIMIT/OFFSET) ����� �������� ����� �������� ��� ������� ��������� ��������.
���� �� � ��������� �������� ������������ ��������� �� ��������� ��������(�������� ��������� ajax).
���� ��������� ������ ���������! (� ��������� � �����������), ��� ����������� �������� �������� ��� �������
��������� offset, ��� ��� ������ ��������� � ������ �� ������ ���������� �������, 
����� ������ ����������  covering index. ������ �������������� ������� � ����������� � � �������
�������� ids �������� �� �������� � �����������, � ����� join � �������� �������� ������� �� ids.

���� �������� �������� �������� ���� ������������, � �������� �������� �������� ��������� �� ������ ��������
� �������� ������ �������� (������ ���������� ����� ���� �������), ������ js ������������ � ����� ��������.
�������� ��������� �����! ��������� ������ ��� ���������� ������� � ��� ���������� (������ �� ��� �� �������).

//��������� �������� ���������� �������(Lorem Ipsum) � ��� � �������, ��� � �������� � ��� ����������
php generator.php 2>&1 &
http://prntscr.com/thz78h

���������� ���������� ��������, ����������/��������������(��������) ��������, �������� ��������.
��������������/�������� �� ������� � ������ �� �������� http://prntscr.com/thz57e
���������� �� ������� �������.
���������� � ���������� �� ��������� � ����, ���������� ����� ���-�� ��������� � ������� �������� �������
http://prntscr.com/ti00yj

//���� ��� ��������, �� �� ������� �� � ��������� ��� ���

1.config file for connect database ./ideal/classes/Config.php
2. dump dor database: dump_db.sql
3. folder uploads chmod(0755)
_----
on native php, mysql, memcached, jquery, bootstrap
    
    

