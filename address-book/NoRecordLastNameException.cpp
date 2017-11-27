#include "NoRecordLastNameException.h"

const char* NoRecordLastNameException::what() const throw()
{
    return "There is no contact of the given last name";
}


