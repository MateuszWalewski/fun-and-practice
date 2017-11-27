#include "NoRecordIdException.h"

const char* NoRecordIdException::what() const throw()
{
    return "There is no contact with the given id";
}

